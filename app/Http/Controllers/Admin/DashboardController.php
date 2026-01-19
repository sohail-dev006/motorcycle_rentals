<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MotorcycleBooking;
use App\Models\Motorcycle;
use App\Models\Customer;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // =====================
        // COUNTS
        // =====================
        $totalMotorcycleBookings = MotorcycleBooking::count();
        $approvedBookings = MotorcycleBooking::where('status','confirmed')->count();
        $cancelledBookings = MotorcycleBooking::where('status','cancelled')->count();
        $dueBookings = MotorcycleBooking::whereDate('pick_date', today())->count();

        $customers = Customer::count();

        // =====================
        // MOTORCYCLE AVAILABILITY
        // =====================
        $totalMotorcycles = Motorcycle::count();

        $bookedMotorcycles = MotorcycleBooking::where('drop_date','>=', today())
            ->where('status','!=','cancelled')
            ->distinct('motorcycle_id')
            ->count('motorcycle_id');

        $availableMotorcycles = $totalMotorcycles - $bookedMotorcycles;

        // =====================
        // TODAY PICK / DROP
        // =====================
        $todayPickups = MotorcycleBooking::whereDate('pick_date', today())->count();
        $todayDrops   = MotorcycleBooking::whereDate('drop_date', today())->count();

        // =====================
        // REVENUE
        // =====================
        // $motorcycleRevenue = MotorcycleBooking::where('status','confirmed')
        //     ->sum('total_price');

        // =====================
        // RECENT BOOKINGS
        // =====================
        $recentBookings = MotorcycleBooking::with('motorcycle')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalMotorcycleBookings',
            'approvedBookings',
            'cancelledBookings',
            'dueBookings',
            'customers',
            'totalMotorcycles',
            'bookedMotorcycles',
            'availableMotorcycles',
            'todayPickups',
            'todayDrops',
            // 'motorcycleRevenue',
            'recentBookings'
        ));
    }
}
