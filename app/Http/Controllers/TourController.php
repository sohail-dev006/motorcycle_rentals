<?php


namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TourController extends Controller
{
    public function index(Request $request)
    {
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
        return view('tours.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:featured,unfeatured',
            'group_price' => 'required|numeric|min:0',
            'private_price' => 'required|numeric|min:0',
            'passenger_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data['slug'] = Str::slug($request->name) . '-' . uniqid();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('tours', 'public');
        }

        Tour::create($data);

        return redirect()->route('tours.index')->with('success', 'Tour added successfully!');
    }

    public function edit(Tour $tour)
    {
        return view('tours.edit', compact('tour'));
    }

    public function update(Request $request, Tour $tour)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:featured,unfeatured',
            'group_price' => 'required|numeric|min:0',
            'private_price' => 'required|numeric|min:0',
            'passenger_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data['slug'] = Str::slug($request->name) . '-' . uniqid();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('tours', 'public');
        }

        $tour->update($data);

        return redirect()->route('tours.index')->with('success', 'Tour updated successfully!');
    }

    public function show(Tour $tour)
    {
        return view('tours.show', compact('tour'));
    }

    public function destroy(Tour $tour)
    {
        // if ($tour->image) {
        //     \Storage::disk('public')->delete($tour->image);
        // }
        $tour->delete();

        return redirect()->route('tours.index')->with('success', 'Tour deleted successfully!');
    }
}
