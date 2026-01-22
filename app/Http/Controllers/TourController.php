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
