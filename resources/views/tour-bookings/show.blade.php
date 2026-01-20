@extends('layouts.admin')
@section('title','Booking Details')
@section('page-title','Booking Details')

@section('content')
<div class="card shadow-sm border-0 p-4">
    <div class="row">
        {{-- Tour Image --}}
        <div class="col-md-4 text-center mb-3">
            <img src="{{ $tourBooking->tour && $tourBooking->tour->image ? asset('storage/'.$tourBooking->tour->image) : asset('images/no-image.png') }}"
                 alt="{{ $tourBooking->tour ? $tourBooking->tour->name : 'Tour Image' }}"
                 class="img-fluid rounded shadow-sm">
        </div>

        {{-- Booking Details --}}
        <div class="col-md-8">
            <h4 class="mb-3">{{ $tourBooking->tour ? $tourBooking->tour->name : '—' }}</h4>

            <div class="mb-2">
                <strong>Customer:</strong>
                <span>{{ $tourBooking->customer ? $tourBooking->customer->first_name . ' ' . $tourBooking->customer->last_name : '—' }}</span>
            </div>

            <div class="mb-2">
                <strong>Motorcycle:</strong>
                <span>{{ $tourBooking->motorcycle ? $tourBooking->motorcycle->name : '—' }}</span>
            </div>

            <div class="mb-2">
                <strong>Pick Date:</strong>
                <span>{{ \Carbon\Carbon::parse($tourBooking->pick_date)->format('d-m-Y') }}</span>
            </div>

            <div class="mb-2">
                <strong>Status:</strong>
                <span class="badge 
                    {{ $tourBooking->status === 'approved' ? 'bg-success' : ($tourBooking->status === 'cancelled' ? 'bg-danger' : 'bg-warning') }}">
                    {{ ucfirst($tourBooking->status) }}
                </span>
            </div>

            <h5 class="mt-3">Price Summary</h5>
            <table class="table table-sm table-bordered w-75">
                <tbody>
                    <tr>
                        <td>Group</td>
                        <td>AED {{ number_format($tourBooking->group_price,2) }}</td>
                    </tr>
                    <tr>
                        <td>Private</td>
                        <td>AED {{ number_format($tourBooking->private_price,2) }}</td>
                    </tr>
                    <tr>
                        <td>Passenger</td>
                        <td>AED {{ number_format($tourBooking->passenger_price,2) }}</td>
                    </tr>
                    <tr>
                        <td>VAT 5%</td>
                        <td>AED {{ number_format($tourBooking->vat,2) }}</td>
                    </tr>
                    <tr class="fw-bold">
                        <td>Total</td>
                        <td>AED {{ number_format($tourBooking->total_price,2) }}</td>
                    </tr>
                </tbody>
            </table>

            <h5 class="mt-3">Description</h5>
            <p>{{ $tourBooking->description ?? '—' }}</p>

            <a href="{{ route('tour-bookings.index') }}" class="btn btn-secondary mt-3">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>
</div>
@endsection
