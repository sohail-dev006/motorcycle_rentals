<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddOnRequest;
use App\Models\AddOn;
use Illuminate\Http\Request;
use Illuminate\Container\Attributes\Storage;

class AddOnController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('addon-list'))) {
            abort(403, 'Unauthorized action.');
        }
        $search = $request->search;

        $addons = AddOn::when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            })
            ->latest()
            ->paginate(10);

        return view('add.index', compact('addons', 'search'));
    }

    public function create()
    {
        
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('add-addon'))) {
            abort(403, 'Unauthorized action.');
        }
        return view('add.create', );
    }
    public function store(AddOnRequest $request)
    {
        $request->validated();

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('addons', 'public');
        }

        AddOn::create($data);

        return redirect()
               ->route('add.index')
               ->with('success', 'Add On created successfully');
    }
    public function edit(AddOn $add)
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('edit-addon'))) {
            abort(403, 'Unauthorized action.');
        }
        return view('add.edit', [
            'addon' => $add
        ]);
    }

    public function update(AddOnRequest $request, AddOn $add)
    {
        $request->validated();

        $data = $request->only(['name', 'price', 'description']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('addons', 'public');
        }

        $add->update($data);

        return redirect()->route('add.index')
            ->with('success', 'Add On updated successfully');
    }
    public function show(AddOn $add)
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('addon-list'))) {
            abort(403, 'Unauthorized action.');
        }
        return view('add.show', [
            'addon' => $add
        ]);
    }


    public function destroy(AddOn $add)
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('delete-addon'))) {
            abort(403, 'Unauthorized action.');
        }

        $add->delete();

        return redirect()
            ->route('add.index')
            ->with('success', 'Add On deleted successfully');
    }


}
