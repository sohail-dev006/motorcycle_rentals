<?php

namespace App\Http\Controllers;

use App\Http\Requests\TourBookingRequest;
use App\Models\TourBooking;
use App\Models\Customer;
use App\Models\Tour;
use App\Models\Motorcycle;
use Illuminate\Http\Request;

class TourBookingController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('tour-booking-list'))) {
            abort(403, 'Unauthorized action.');
        }
        $bookings = TourBooking::with(['customer','tour','motorcycle'])->latest()->paginate(10);
        return view('tour-bookings.index', compact('bookings'));
    }

    public function create()
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('add-tour-booking'))) {
            abort(403, 'Unauthorized action.');
        }
        $tours = Tour::all();
        $motorcycles = Motorcycle::all();
        $customers = Customer::all();
        return view('tour-bookings.create', compact('tours','motorcycles','customers'));
    }

    public function store(TourBookingRequest $request)
    {
        $data = $request->validated();

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
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('tour-booking-list'))) {
            abort(403, 'Unauthorized action.');
        }
        return view('tour-bookings.show', compact('tourBooking'));
    }

    public function edit(TourBooking $tourBooking)
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('edit-tour-booking'))) {
            abort(403, 'Unauthorized action.');
        }
        $tours = Tour::all();
        $motorcycles = Motorcycle::all();
        $customers = Customer::all();
        return view('tour-bookings.edit', compact('tourBooking','tours','motorcycles','customers'));
    }

    public function update(TourBookingRequest $request, TourBooking $tourBooking)
    {
        $data = $request->validated();

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
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('delete-tour-booking'))) {
            abort(403, 'Unauthorized action.');
        }
        $tourBooking->delete();
        return redirect()->route('tour-bookings.index')->with('success','Booking deleted successfully!');
    }
}
