<?php


namespace App\Http\Controllers;

use App\Http\Requests\TourRequest;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TourController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('tour-list'))) {
            abort(403, 'Unauthorized action.');
        }
        $search = $request->search;

        $tours = Tour::when($search, function ($q) use ($search) {
            $q->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('group_price', 'like', "%{$search}%")
                    ->orWhere('private_price', 'like', "%{$search}%");
            });
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

        return view('tours.index', compact('tours'));
    }


    public function create()
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('add-tour'))) {
            abort(403, 'Unauthorized action.');
        }
        return view('tours.create');
    }

    public function store(TourRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($request->name) . '-' . uniqid();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('tours', 'public');
        }

        Tour::create($data);

        return redirect()->route('tours.index')->with('success', 'Tour added successfully!');
    }
    public function import(Request $request)
    {
        $user = auth()->user();
        if (!($user->hasRole('Super Admin') || $user->can('csv-tour'))) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('file')->getRealPath();

        if (($handle = fopen($file, 'r')) !== FALSE) {
            $header = fgetcsv($handle, 1000, ",");
            $header = array_map(fn($h) => strtolower(trim($h)), $header);

            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if (count($row) !== count($header)) continue;

                $data = array_combine($header, $row);

                if (empty($data['name'])) continue;

                $slug = Str::slug($data['name']);
                $originalSlug = $slug;
                $i = 1;
                while (Tour::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $i;
                    $i++;
                }

                $imagePath = null;
                if (!empty($data['image_url'])) {
                    try {
                        $imageContents = file_get_contents($data['image_url']);
                        $imageName = Str::random(20) . '.' . pathinfo($data['image_url'], PATHINFO_EXTENSION);
                        \Storage::disk('public')->put('tours/' . $imageName, $imageContents);
                        $imagePath = 'tours/' . $imageName;
                    } catch (\Exception $e) {
                        $imagePath = null;
                    }
                }

                Tour::create([
                    'name' => $data['name'],
                    'status' => $data['status'] ?? 'active',
                    'group_price' => $data['group_price'] ?? 0,
                    'private_price' => $data['private_price'] ?? 0,
                    'passenger_price' => $data['passenger_price'] ?? 0,
                    'slug' => $slug,
                    'image' => $imagePath,
                ]);
            }

            fclose($handle);
        }

        return redirect()->back()->with('success', 'CSV imported successfully! Tours added.');
    }


    public function edit(Tour $tour)
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('edit-tour'))) {
            abort(403, 'Unauthorized action.');
        }
        return view('tours.edit', compact('tour'));
    }

    public function update(TourRequest $request, Tour $tour)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($request->name) . '-' . uniqid();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('tours', 'public');
        }

        $tour->update($data);

        return redirect()->route('tours.index')->with('success', 'Tour updated successfully!');
    }

    public function show(Tour $tour)
    {

        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('tour-list'))) {
            abort(403, 'Unauthorized action.');
        }
        return view('tours.show', compact('tour'));
    }

    public function destroy(Tour $tour)
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('delete-tour'))) {
            abort(403, 'Unauthorized action.');
        }
        // if ($tour->image) {
        //     \Storage::disk('public')->delete($tour->image);
        // }
        $tour->delete();

        return redirect()->route('tours.index')->with('success', 'Tour deleted successfully!');
    }
}
