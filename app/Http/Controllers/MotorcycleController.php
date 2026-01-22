<?php

namespace App\Http\Controllers;

use App\Http\Requests\MotorCycleRequest;
use App\Models\Motorcycle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Brand;
use League\Csv\Reader;
use Illuminate\Support\Facades\Storage;


class MotorcycleController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('motorcycle-list'))) {
            abort(403, 'Unauthorized action.');
        }
        $query = Motorcycle::query();


        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%");
        }

        $motorcycles = $query->paginate(10)->withQueryString();
        return view('motorcycles.index', compact('motorcycles'));
    }
    public function import(Request $request)
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('csv-motorcycle'))) {
            abort(403, 'Unauthorized action.');
        }
        // Validate file
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();

        if (($handle = fopen($path, 'r')) !== FALSE) {
            
            $header = fgetcsv($handle, 1000, ",");

        
            $header = array_map(fn($h) => strtolower(trim($h)), $header);

            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if (count($row) !== count($header)) {
                    continue;
                }

                
                $data = array_combine($header, $row);

                
                if (empty($data['name'])) {
                    continue;
                }

                
                $slug = Str::slug($data['name']);
                $originalSlug = $slug;
                $i = 1;
                while (Motorcycle::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $i;
                    $i++;
                }

               
                $imagePath = null;
                if (!empty($data['image_url'])) {
                    try {
                        $imageContents = file_get_contents($data['image_url']);
                        $imageName = Str::random(20) . '.' . pathinfo($data['image_url'], PATHINFO_EXTENSION);
                        Storage::disk('public')->put('motorcycles/' . $imageName, $imageContents);
                        $imagePath = 'motorcycles/' . $imageName;
                    } catch (\Exception $e) {
                        $imagePath = null; 
                    }
                }


                Motorcycle::create([
                    'name' => $data['name'],
                    'code' => $data['code'] ?? null,
                    'sort_order' => $data['sort_order'] ?? 0,
                    'status' => $data['status'] ?? 'active',
                    'price' => ($data['base_price'] ?? 0) + ($data['extra_price'] ?? 0),
                    'slug' => $slug,
                    'image' => $imagePath,
                ]);
            }

            fclose($handle);
        }

        return redirect()->back()->with('success', 'CSV imported successfully! Motorcycles added.');
    }


    

    public function create()
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('add-motorcycle'))) {
            abort(403, 'Unauthorized action.');
        }
        $brands = Brand::all();
        return view('motorcycles.create', compact('brands'));
    }

    public function store(MotorCycleRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($request->name) . '-' . uniqid();
        $data['price'] = ($data['base_price'] ?? 0) + ($data['extra_price'] ?? 0);



        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('motorcycles', 'public');
        }

        Motorcycle::create($data);

        return redirect()
            ->route('motorcycles.index')
            ->with('success', 'Motorcycle added successfully');
    }

    public function show(Motorcycle $motorcycle)
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('motorcycle-list'))) {
            abort(403, 'Unauthorized action.');
        }
        return view('motorcycles.show', compact('motorcycle'));
    }

    public function edit(Motorcycle $motorcycle)
    {

        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('edit-motorcycle'))) {
            abort(403, 'Unauthorized action.');
        }
        $brands = Brand::all();
        return view('motorcycles.edit', compact('motorcycle', 'brands'));
    }

    public function update(MotorCycleRequest $request, Motorcycle $motorcycle)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('motorcycles', 'public');
        }
        $data['price'] = ($data['base_price'] ?? 0) + ($data['extra_price'] ?? 0);



        $motorcycle->update($data);

        return redirect()
            ->route('motorcycles.index')
            ->with('success', 'Motorcycle updated successfully');
    }

    public function destroy(Motorcycle $motorcycle)
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('delete-motorcycle'))) {
            abort(403, 'Unauthorized action.');
        }
        $motorcycle->delete();

        return redirect()
            ->route('motorcycles.index')
            ->with('success', 'Motorcycle deleted successfully');
    }
}

