<?php

namespace App\Http\Controllers;

use App\Http\Requests\MotorcycleBookingRequest;
use App\Models\MotorcycleBooking;
use App\Models\Customer;
use App\Models\Motorcycle;
use App\Models\AddOn;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MotorcycleBookingController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('motorcycle-booking-list'))) {
            abort(403, 'Unauthorized action.');
        }
        $search = $request->search;

        $bookings = MotorcycleBooking::with(['customer', 'motorcycle'])
            ->when($search, function($q) use ($search) {
                $q->whereHas('customer', fn($c) => $c->where('first_name', 'like', "%$search%")
                                                    ->orWhere('last_name', 'like', "%$search%"))
                  ->orWhereHas('motorcycle', fn($m) => $m->where('name', 'like', "%$search%"));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('bookings.index', compact('bookings', 'search'));
    }

    public function create()
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('add-motorcycle-booking'))) {
            abort(403, 'Unauthorized action.');
        }
        $customers = Customer::all();
        $addons = AddOn::all();

        $today = Carbon::today();

        $bookedMotorcycles = MotorcycleBooking::where(function($q) use ($today) {
                $q->whereDate('pick_date', '<=', $today)
                ->whereDate('drop_date', '>=', $today);
            })
            ->pluck('motorcycle_id')
            ->toArray();

        $motorcycles = Motorcycle::whereNotIn('id', $bookedMotorcycles)->get();

        return view('bookings.create', compact('customers', 'motorcycles', 'addons'));
    }

    public function store(MotorcycleBookingRequest $request)
    {
        $data = $request->validated();

        $data['addons'] = $request->addons ?? [];

        MotorcycleBooking::create($data);

        return redirect()->route('bookings.index')
                         ->with('success', 'Booking created successfully.');
    }

    public function show(MotorcycleBooking $booking)
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('motorcycle-booking-list'))) {
            abort(403, 'Unauthorized action.');
        }
        $booking->load(['customer', 'motorcycle']);
        return view('bookings.show', compact('booking'));
    }


    public function edit(MotorcycleBooking $booking)
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('edit-motorcycle-booking'))) {
            abort(403, 'Unauthorized action.');
        }
        $customers = Customer::all();
        $addons = AddOn::all();

        $today = Carbon::today();

        $bookedMotorcycles = MotorcycleBooking::where(function($q) use ($today) {
                $q->whereDate('pick_date', '<=', $today)
                ->whereDate('drop_date', '>=', $today);
            })
            ->where('id', '!=', $booking->id) // ignore current booking
            ->pluck('motorcycle_id')
            ->toArray();

        $motorcycles = Motorcycle::whereNotIn('id', $bookedMotorcycles)
                                ->orWhere('id', $booking->motorcycle_id) // allow current bike
                                ->get();

        return view('bookings.edit', compact('booking', 'customers', 'motorcycles', 'addons'));
    }


    public function update(MotorcycleBookingRequest $request, MotorcycleBooking $booking)
    {
        $data = $request->validated();

        $data['addons'] = $request->addons ?? [];

        $booking->update($data);

        return redirect()->route('bookings.index')
                         ->with('success', 'Booking updated successfully.');
    }

    public function destroy(MotorcycleBooking $booking)
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('delete-motorcycle-booking'))) {
            abort(403, 'Unauthorized action.');
        }
        $booking->delete();

        return redirect()->route('bookings.index')
                         ->with('success', 'Booking deleted successfully.');
    }
}
