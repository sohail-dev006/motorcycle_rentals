<?php

namespace App\Http\Controllers;

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
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $csvData = file_get_contents($file);
        $lines = explode(PHP_EOL, $csvData);
        $header = null;

        foreach ($lines as $key => $line) {
            $data = str_getcsv($line);

            if ($key === 0) {
                $header = $data; 
                continue;
            }

            if (count($data) === count($header)) {
                $row = array_combine($header, $data);

                $imagePath = null;
                if (!empty($row['image_url'])) {
                    try {
                        $imageContents = file_get_contents($row['image_url']);
                        $imageName = Str::random(20) . '.' . pathinfo($row['image_url'], PATHINFO_EXTENSION);
                        Storage::disk('public')->put('motorcycles/' . $imageName, $imageContents);
                        $imagePath = 'motorcycles/' . $imageName;
                    } catch (\Exception $e) {
                        
                        $imagePath = null;
                    }
                }

                // Create Motorcycle
                Motorcycle::create([
                    'name' => $row['name'] ?? null,
                    'code' => $row['code'] ?? null,
                    'sort_order' => $row['sort_order'] ?? 0,
                    'status' => $row['status'] ?? 'active',
                    'price' => $row['price'] ?? 0,
                    'image' => $imagePath,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Motorcycles imported successfully!');
    }


    public function create()
    {
        $brands = Brand::all();
        return view('motorcycles.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'quantity' => 'nullable|integer|min:0',
            'sort_order' => 'nullable|integer|min:0',
            'brand_id' => 'nullable|integer',
            'status' => 'required|in:featured,unfeatured',
            'visibility' => 'required|in:show,hide',
            'base_price' => 'required|numeric|min:0',
            'extra_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data['slug'] = Str::slug($request->name) . '-' . uniqid();

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
        return view('motorcycles.show', compact('motorcycle'));
    }

    public function edit(Motorcycle $motorcycle)
    {
        $brands = Brand::all();
        return view('motorcycles.edit', compact('motorcycle', 'brands'));
    }

    public function update(Request $request, Motorcycle $motorcycle)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'quantity' => 'nullable|integer|min:0',
            'sort_order' => 'nullable|integer|min:0',
            'brand_id' => 'nullable|exists:brands,id',
            'status' => 'required|in:featured,unfeatured',
            'visibility' => 'required|in:show,hide',
            'base_price' => 'required|numeric|min:0',
            'extra_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('motorcycles', 'public');
        }

        $motorcycle->update($data);

        return redirect()
            ->route('motorcycles.index')
            ->with('success', 'Motorcycle updated successfully');
    }

    public function destroy(Motorcycle $motorcycle)
    {
                      
        $motorcycle->delete();

        return redirect()
            ->route('motorcycles.index')
            ->with('success', 'Motorcycle deleted successfully');
    }
}

