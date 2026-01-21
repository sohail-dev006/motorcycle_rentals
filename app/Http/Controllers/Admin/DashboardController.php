<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TourBooking;
use App\Models\Customer;
use App\Models\Tour;
use App\Models\Motorcycle;
use App\Models\MotorcycleBooking;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('view-dashboard'))) {
            abort(403, 'Unauthorized action.');
        }
        $today = Carbon::today();

        // TOTAL BOOKINGS
        $totalTourBookings = TourBooking::count();
        $approvedBookings  = TourBooking::where('status','approved')->count();
        $pendingBookings   = TourBooking::where('status','pending')->count();
        $cancelledBookings = TourBooking::where('status','cancelled')->count();

        // DUE BOOKINGS TODAY
        $dueBookings = TourBooking::whereDate('pick_date', $today)
            ->whereIn('status', ['approved','pending'])
            ->count();

        // CUSTOMERS
        $customers = Customer::count();

        // MOTORCYCLE AVAILABILITY
        $totalMotorcycles = Motorcycle::count();

        $bookedMotorcycleIds = MotorcycleBooking::where('status','!=','cancelled')
            ->whereDate('pick_date', '<=', $today)
            ->whereDate('drop_date', '>=', $today)
            ->pluck('motorcycle_id')
            ->toArray();

        $bookedMotorcycles   = count($bookedMotorcycleIds);
        $availableMotorcycles = $totalMotorcycles - $bookedMotorcycles;

        // TODAY PICKUPS / DROPS
        $todayPickups = TourBooking::whereDate('pick_date', $today)
            ->whereIn('status',['approved','pending'])
            ->count();

        $todayDrops = MotorcycleBooking::whereDate('drop_date', $today)
            ->whereIn('status',['approved','pending'])
            ->count();

        // RECENT BOOKINGS (latest 5)
        $recentBookings = TourBooking::with(['motorcycle','customer','tour'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalTourBookings',
            'approvedBookings',
            'pendingBookings',
            'cancelledBookings',
            'dueBookings',
            'customers',
            'totalMotorcycles',
            'bookedMotorcycles',
            'availableMotorcycles',
            'todayPickups',
            'todayDrops',
            'recentBookings'
        ));
    }
}
