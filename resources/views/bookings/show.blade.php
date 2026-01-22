@extends('layouts.admin')

@section('title','View Booking')
@section('page-title','Motorcycle Booking Details')

@section('content')
<div class="card shadow-sm border-0 p-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Motorcycle Booking Details</h4>
            <small class="text-white">Complete information about this booking</small>
        </div>
        <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary rounded-pill">
            <i class="fa fa-arrow-left me-1"></i> Back
        </a>
    </div>

    {{-- Customer & Motorcycle Info --}}
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card border-light shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    @if($booking->customer->image)
                    <img src="{{ asset('storage/'.$booking->customer->image) }}" 
                         alt="Customer" class="rounded-circle" width="60" height="60" style="object-fit: cover;">
                    @else
                    <i class="fa fa-user-circle fa-3x text-white"></i>
                    @endif
                    <div>
                        <h6 class="mb-1 fw-semibold">{{ $booking->customer->first_name }} {{ $booking->customer->last_name }}</h6>
                        <small class="text-white">Customer</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card border-light shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    @if($booking->motorcycle->image)
                    <img src="{{ asset('storage/'.$booking->motorcycle->image) }}" 
                         alt="Motorcycle" class="rounded" width="80" height="60" style="object-fit: cover;">
                    @else
                    <i class="fa fa-motorcycle fa-3x text-white"></i>
                    @endif
                    <div>
                        <h6 class="mb-1 fw-semibold">{{ $booking->motorcycle->name }}</h6>
                        <small class="text-white">Motorcycle</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Pick & Drop Dates --}}
    <div class="row mb-4">
        @php
            $totalDays = \Carbon\Carbon::parse($booking->pick_date)
                            ->diffInDays(\Carbon\Carbon::parse($booking->drop_date)) + 1;
        @endphp
        <div class="col-md-3 mb-3">
            <div class="card p-3 h-100 border-light shadow-sm text-center">
                <h6 class="text-white mb-1">Pick Date</h6>
                <p class="fw-semibold mb-0">{{ \Carbon\Carbon::parse($booking->pick_date)->format('d-m-Y') }}</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card p-3 h-100 border-light shadow-sm text-center">
                <h6 class="text-white mb-1">Drop Date</h6>
                <p class="fw-semibold mb-0">{{ \Carbon\Carbon::parse($booking->drop_date)->format('d-m-Y') }}</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card p-3 h-100 border-light shadow-sm text-center">
                <h6 class="text-white mb-1">Pick Time</h6>
                <p class="fw-semibold mb-0">{{ \Carbon\Carbon::parse($booking->pick_time)->format('h:i A') }}</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card p-3 h-100 border-light shadow-sm text-center">
                <h6 class="text-white mb-1">Drop Time</h6>
                <p class="fw-semibold mb-0">{{ \Carbon\Carbon::parse($booking->drop_time)->format('h:i A') }}</p>
            </div>
        </div>
    </div>

    {{-- Pricing Card --}}
    <div class="card mb-4 border-light shadow-sm p-3">
        <h6 class="fw-bold mb-3">Pricing Details</h6>
        @php
            $addonPerDay = 450; // example
            $addonsTotal = $addonPerDay * $totalDays;
            $vat = 0.05 * ($booking->motorcycle->base_price + $addonsTotal);
            $totalPrice = $booking->motorcycle->base_price + $addonsTotal + $vat;
        @endphp
        <div class="row text-center">
            <div class="col-md-3 mb-2">
                <p class="text-white mb-1">Base Price</p>
                <h6 class="fw-semibold">AED {{ number_format($booking->motorcycle->base_price,2) }}</h6>
            </div>
            <div class="col-md-3 mb-2">
                <p class="text-white mb-1">Add-ons</p>
                <h6 class="fw-semibold">{{ $booking->addons ? implode(', ', $booking->addons) : '—' }}</h6>
            </div>
            <div class="col-md-2 mb-2">
                <p class="text-white mb-1">Add-on/Day</p>
                <h6 class="fw-semibold">AED {{ number_format($addonPerDay,2) }}</h6>
            </div>
            <div class="col-md-2 mb-2">
                <p class="text-white mb-1">Add-ons Total</p>
                <h6 class="fw-semibold">AED {{ number_format($addonsTotal,2) }}</h6>
            </div>
            <div class="col-md-2 mb-2">
                <p class="text-white mb-1">Total (Incl. VAT)</p>
                <h6 class="fw-semibold">AED {{ number_format($totalPrice,2) }}</h6>
            </div>
        </div>
    </div>

    {{-- Description --}}
    <div class="card border-light shadow-sm p-3">
        <h6 class="fw-bold mb-1">Description</h6>
        <p class="mb-0">{{ $booking->description ?? '—' }}</p>
    </div>

</div>
@endsection
