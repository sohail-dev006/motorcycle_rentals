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
    // List all bookings with optional search
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

    // Show create booking form
    public function create()
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('add-motorcycle-booking'))) {
            abort(403, 'Unauthorized action.');
        }

        $customers = Customer::all();
        $addons = AddOn::all();
        $motorcycles = Motorcycle::all();

        $now = Carbon::now();

        $bookedMotorcycles = MotorcycleBooking::get()->filter(function($b) use ($now) {
        $pick = Carbon::parse($b->pick_date)
                    ->setTimeFromTimeString($b->pick_time);

        $drop = Carbon::parse($b->drop_date)
                    ->setTimeFromTimeString($b->drop_time);


            return $now->between($pick, $drop);
        })->pluck('motorcycle_id')->toArray();

        $availableMotorcycles = Motorcycle::whereNotIn('id', $bookedMotorcycles)->get();

        return view('bookings.create', [
            'customers' => $customers,
            'addons' => $addons,
            'motorcycles' => $availableMotorcycles,
        ]);
    }

    // Store booking
    public function store(MotorcycleBookingRequest $request)
    {
        $data = $request->validated();
        $data['addons'] = $request->addons ?? [];

        // Save booking
        MotorcycleBooking::create($data);

        return redirect()->route('bookings.index')
                         ->with('success', 'Booking created successfully.');
    }

    // Show single booking
    public function show(MotorcycleBooking $booking)
    {
        $user = auth()->user();
        if (!($user->hasRole('Super Admin') || $user->can('motorcycle-booking-list'))) {
            abort(403, 'Unauthorized action.');
        }

        $booking->load(['customer', 'motorcycle']);
        return view('bookings.show', compact('booking'));
    }

    // Edit booking
    public function edit(MotorcycleBooking $booking)
    {
        $user = auth()->user();
        if (!($user->hasRole('Super Admin') || $user->can('edit-motorcycle-booking'))) {
            abort(403, 'Unauthorized action.');
        }

        $customers = Customer::all();
        $addons = AddOn::all();
        $now = Carbon::now();

        $bookedMotorcycles = MotorcycleBooking::where('id', '!=', $booking->id)->get()->filter(function($b) use ($now) {
        $pick = Carbon::parse($b->pick_date)
                    ->setTimeFromTimeString($b->pick_time);

        $drop = Carbon::parse($b->drop_date)
                    ->setTimeFromTimeString($b->drop_time);
            return $pick <= $now && $drop >= $now;
        })->pluck('motorcycle_id')->toArray();

        $motorcycles = Motorcycle::whereNotIn('id', $bookedMotorcycles)
                                ->orWhere('id', $booking->motorcycle_id)
                                ->get();

        return view('bookings.edit', compact('booking', 'customers', 'motorcycles', 'addons'));
    }

    // Update booking
    public function update(MotorcycleBookingRequest $request, MotorcycleBooking $booking)
    {
        $data = $request->validated();
        $data['addons'] = $request->addons ?? [];

        $booking->update($data);

        return redirect()->route('bookings.index')
                         ->with('success', 'Booking updated successfully.');
    }

    // Delete booking
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

    // Helper function to calculate number of days including partial days
    public static function calculateBookingDays($pickDate, $pickTime, $dropDate, $dropTime)
    {
        $pick = Carbon::parse($pickDate . ' ' . $pickTime);
        $drop = Carbon::parse($dropDate . ' ' . $dropTime);

        $hours = $drop->diffInHours($pick);
        $days = ceil($hours / 24); // any extra hour counts as a full day

        return max(1, $days); // at least 1 day
    }
}
