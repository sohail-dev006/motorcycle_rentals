<?php

namespace App\Http\Controllers;

use App\Models\AddOn;
use Illuminate\Http\Request;
use Illuminate\Container\Attributes\Storage;

class AddOnController extends Controller
{
    public function index(Request $request)
    {
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
        return view('add.create', );
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

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
        return view('add.edit', [
            'addon' => $add
        ]);
    }

    public function update(Request $request, AddOn $add)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

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
        return view('add.show', [
            'addon' => $add
        ]);
    }


    public function destroy(AddOn $add)
    {
        $add->delete();

        return redirect()
            ->route('add.index')
            ->with('success', 'Add On deleted successfully');
    }

}
