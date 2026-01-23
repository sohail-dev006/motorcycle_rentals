<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MotorcycleBooking;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = MotorcycleBooking::with(['customer','motorcycle'])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Bookings fetched successfully',
            'data' => $bookings
        ], 200);
    }
}
