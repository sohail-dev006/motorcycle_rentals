<?php

namespace App\Http\Controllers;

use App\Models\Motorcycle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MotorcycleController extends Controller
{
    public function index()
    {
        $motorcycles = Motorcycle::latest()->paginate(10);
        return view('motorcycles.index', compact('motorcycles'));
    }


    public function create()
    {
        return view('motorcycles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:motorcycles,slug',
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

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('motorcycles', 'public');
        }

        Motorcycle::create($data);

        return redirect()->route('motorcycles.index')->with('success', 'Motorcycle added successfully!');


    }
}
