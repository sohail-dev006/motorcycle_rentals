<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('brand-list'))) {
            abort(403, 'Unauthorized action.');
        }
        $search = $request->search;

        $brands = Brand::when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString(); 

        return view('brands.index', compact('brands', 'search'));
    }


    public function create()
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('add-brand'))) {
            abort(403, 'Unauthorized action.');
        }
        return view('brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
        ]);

        Brand::create($request->only('name'));

        return redirect()->route('brands.index')
                         ->with('success', 'Brand created successfully.');
    }

    public function edit(Brand $brand)
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('edit-brand'))) {
            abort(403, 'Unauthorized action.');
        }
        return view('brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
        ]);

        $brand->update($request->only('name'));

        return redirect()->route('brands.index')
                         ->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand)
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('delete-brand'))) {
            abort(403, 'Unauthorized action.');
        }
        $brand->delete();

        return redirect()->route('brands.index')
                         ->with('success', 'Brand deleted successfully.');
    }
}
