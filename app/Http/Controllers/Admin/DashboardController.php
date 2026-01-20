<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TourBooking;
use App\Models\Customer;
use App\Models\Tour;
use App\Models\Motorcycle;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // COUNTS
        $totalTourBookings = TourBooking::count();
        $approvedBookings   = TourBooking::where('status','approved')->count();
        $cancelledBookings  = TourBooking::where('status','cancelled')->count();
        $dueBookings        = TourBooking::whereDate('pick_date', today())->count();

        $customers = Customer::count();

        // MOTORCYCLE AVAILABILITY
        $totalMotorcycles = Motorcycle::count();

        $bookedMotorcycles = TourBooking::whereDate('pick_date', '<=', today())
            ->whereDate('pick_date', '>=', today())
            ->where('status','approved')
            ->distinct('motorcycle_id')
            ->count('motorcycle_id');

        $availableMotorcycles = $totalMotorcycles - $bookedMotorcycles;

        // TODAY PICK / DROP
        $todayPickups = TourBooking::whereDate('pick_date', today())->count();
        $todayDrops   = TourBooking::whereDate('pick_date', today())->count(); 

        // RECENT BOOKINGS
        $recentBookings = TourBooking::with(['motorcycle','customer','tour'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalTourBookings',
            'approvedBookings',
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
