<?php

namespace App\Http\Controllers;

use App\Models\TourBooking;
use App\Models\Customer;
use App\Models\Tour;
use App\Models\Motorcycle;
use Illuminate\Http\Request;

class TourBookingController extends Controller
{
    public function index()
    {
        $bookings = TourBooking::with(['customer','tour','motorcycle'])->latest()->paginate(10);
        return view('tour-bookings.index', compact('bookings'));
    }

    public function create()
    {
        $tours = Tour::all();
        $motorcycles = Motorcycle::all();
        $customers = Customer::all();
        return view('tour-bookings.create', compact('tours','motorcycles','customers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id'=>'required|exists:customers,id',
            'tour_id'=>'required|exists:tours,id',
            'motorcycle_id'=>'nullable|exists:motorcycles,id',
            'pick_date'=>'required|date',
            'status'=>'required|in:pending,approved,cancelled',
            'group_price'=>'nullable|numeric|min:0',
            'private_price'=>'nullable|numeric|min:0',
            'passenger_price'=>'required|numeric|min:0',
            'description'=>'nullable|string',
        ]);

        // Validation: Only one of group_price or private_price can be > 0
        if (($data['group_price'] ?? 0) > 0 && ($data['private_price'] ?? 0) > 0) {
            return back()->withInput()->withErrors([
                'group_price' => 'You can only enter either Group Price or Private Price, not both.',
                'private_price' => 'You can only enter either Group Price or Private Price, not both.',
            ]);
        }

        $subtotal = ($data['group_price'] ?? 0) + ($data['private_price'] ?? 0) + $data['passenger_price'];
        $data['vat'] = $subtotal * 0.05;
        $data['total_price'] = $subtotal + $data['vat'];

        TourBooking::create($data);

        return redirect()->route('tour-bookings.index')->with('success','Booking added successfully!');
    }

    public function show(TourBooking $tourBooking)
    {
        return view('tour-bookings.show', compact('tourBooking'));
    }

    public function edit(TourBooking $tourBooking)
    {
        $tours = Tour::all();
        $motorcycles = Motorcycle::all();
        $customers = Customer::all();
        return view('tour-bookings.edit', compact('tourBooking','tours','motorcycles','customers'));
    }

    public function update(Request $request, TourBooking $tourBooking)
    {
        $data = $request->validate([
            'customer_id'=>'required|exists:customers,id',
            'tour_id'=>'required|exists:tours,id',
            'motorcycle_id'=>'nullable|exists:motorcycles,id',
            'pick_date'=>'required|date',
            'status'=>'required|in:pending,approved,cancelled',
            'group_price'=>'nullable|numeric|min:0',
            'private_price'=>'nullable|numeric|min:0',
            'passenger_price'=>'required|numeric|min:0',
            'description'=>'nullable|string',
        ]);

        if (($data['group_price'] ?? 0) > 0 && ($data['private_price'] ?? 0) > 0) {
            return back()->withInput()->withErrors([
                'group_price' => 'You can only enter either Group Price or Private Price, not both.',
                'private_price' => 'You can only enter either Group Price or Private Price, not both.',
            ]);
        }

        $subtotal = ($data['group_price'] ?? 0) + ($data['private_price'] ?? 0) + $data['passenger_price'];
        $data['vat'] = $subtotal * 0.05;
        $data['total_price'] = $subtotal + $data['vat'];

        $tourBooking->update($data);

        return redirect()->route('tour-bookings.index')->with('success','Booking updated successfully!');
    }

    public function destroy(TourBooking $tourBooking)
    {
        $tourBooking->delete();
        return redirect()->route('tour-bookings.index')->with('success','Booking deleted successfully!');
    }
}
