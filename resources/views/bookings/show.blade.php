@extends('layouts.admin')

@section('title','View Booking')
@section('page-title','Motorcycle Booking Details')

@section('content')
<div class="card shadow-sm border-0 p-4">

    <div class="d-flex justify-content-between align-items-start">
        <div class="">
            <h4 class="mb-1 fw-bold">Motorcycle Booking Details</h4>
            <p class="text-muted mb-4">Full details of a motorcycle booking</p>
        </div>
        <div class="text-end">
            <a href="{{ route('bookings.index') }}" class="btn btn-secondary rounded-pill">
                <i class="fa fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>
    {{-- Customer --}}
    <div class="row mb-3 align-items-center">
        <div class="col-md-6">
            <h6 class="text-muted">Customer</h6>
            <p class="fw-semibold">{{ $booking->customer->first_name }} {{ $booking->customer->last_name }}</p>
        </div>
        <div class="col-md-6 text-end">
            @if($booking->customer->image)
                <img src="{{ asset('storage/'.$booking->customer->image) }}" 
                     alt="Customer Image" 
                     class="rounded-circle" 
                     width="80" height="80" style="object-fit: cover;">
            @endif
        </div>
    </div>

    {{-- Motorcycle --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <h6 class="text-muted">Motorcycle</h6>
            <p class="fw-semibold">{{ $booking->motorcycle->name }}</p>
        </div>
        <div class="col-md-6 text-end">
            @if($booking->motorcycle->image)
                <img src="{{ asset('storage/'.$booking->motorcycle->image) }}" 
                     alt="Motorcycle Image" 
                     class="rounded" 
                     width="120" height="80" style="object-fit: cover;">
            @endif
        </div>
    </div>

    {{-- Alternate Motorcycle --}}
    @if(isset($booking->alternate_motorcycle))
    <div class="row mb-3">
        <div class="col-md-6">
            <h6 class="text-muted">Alternate Motorcycle</h6>
            <p class="fw-semibold">{{ $booking->alternate_motorcycle->name }}</p>
        </div>
        <div class="col-md-6 text-end">
            @if($booking->alternate_motorcycle->image)
                <img src="{{ asset('storage/'.$booking->alternate_motorcycle->image) }}" 
                     alt="Alternate Motorcycle Image" 
                     class="rounded" 
                     width="120" height="80" style="object-fit: cover;">
            @endif
        </div>
    </div>
    @endif

    {{-- Pick / Drop Dates & Times --}}
    <div class="row mb-3">
        <div class="col-md-3">
            <h6 class="text-muted">Pick Date</h6>
            <p class="fw-semibold">{{ \Carbon\Carbon::parse($booking->pick_date)->format('d-m-Y') }}</p>
        </div>
        <div class="col-md-3">
            <h6 class="text-muted">Drop Date</h6>
            <p class="fw-semibold">{{ \Carbon\Carbon::parse($booking->drop_date)->format('d-m-Y') }}</p>
        </div>
        <div class="col-md-3">
            <h6 class="text-muted">Pick Time</h6>
            <p class="fw-semibold">{{ \Carbon\Carbon::parse($booking->pick_time)->format('h:i A') }}</p>
        </div>
        <div class="col-md-3">
            <h6 class="text-muted">Drop Time</h6>
            <p class="fw-semibold">{{ \Carbon\Carbon::parse($booking->drop_time)->format('h:i A') }}</p>
        </div>
    </div>

    {{-- Total Days --}}
    @php
        $totalDays = \Carbon\Carbon::parse($booking->pick_date)
                        ->diffInDays(\Carbon\Carbon::parse($booking->drop_date)) + 1;
    @endphp
    <div class="row mb-3">
        <div class="col-md-3">
            <h6 class="text-muted">Total Days</h6>
            <p class="fw-semibold">{{ $totalDays }}</p>
        </div>
    </div>

    {{-- Pricing --}}
    <div class="row mb-3">
        <div class="col-md-3">
            <h6 class="text-muted">Motorcycle Base Price</h6>
            <p class="fw-semibold">AED: {{ number_format($booking->motorcycle->base_price, 2) }}</p>
        </div>
        <div class="col-md-3">
            <h6 class="text-muted">ADD ONs</h6>
            <p class="fw-semibold">{{ $booking->addons ? implode(', ', $booking->addons) : '—' }}</p>
        </div>
        <div class="col-md-3">
            @php
                $addonPerDay = 450; // example, can be dynamic
                $addonsTotal = $addonPerDay * $totalDays;
                $vat = 0.05 * ($booking->motorcycle->base_price + $addonsTotal);
                $totalPrice = $booking->motorcycle->base_price + $addonsTotal + $vat;
            @endphp
            <h6 class="text-muted">ADD ONs Per Day Price</h6>
            <p class="fw-semibold">AED: {{ number_format($addonPerDay, 2) }}</p>
        </div>
        <div class="col-md-3">
            <h6 class="text-muted">ADD ONs Total Price</h6>
            <p class="fw-semibold">AED: {{ number_format($addonsTotal, 2) }}</p>
        </div>
    </div>

    {{-- VAT & Total --}}
    <div class="row mb-3">
        <div class="col-md-3">
            <h6 class="text-muted">5% VAT</h6>
            <p class="fw-semibold">AED: {{ number_format($vat, 2) }}</p>
        </div>
        <div class="col-md-3">
            <h6 class="text-muted">Total Price (Including VAT)</h6>
            <p class="fw-semibold">AED: {{ number_format($totalPrice, 2) }}</p>
        </div>
    </div>

    {{-- Description --}}
    <div class="mb-3">
        <h6 class="text-muted">Description</h6>
        <p class="fw-semibold">{{ $booking->description ?? '—' }}</p>
    </div>


</div>
@endsection
