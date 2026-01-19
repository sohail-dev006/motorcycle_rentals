@extends('layouts.admin')

@section('title','Customer Details')
@section('page-title','Customer Details')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Customer Details</h4>
    <a href="{{ route('customers.index') }}" class="btn btn-secondary rounded-pill">
        <i class="fa fa-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card shadow-sm border-0 p-3">
    <div class="d-flex align-items-center mb-4">
        @if($customer->image)
            <img src="{{ asset('storage/'.$customer->image) }}" 
                 alt="Customer Image"
                 width="100"
                 height="100"
                 class="rounded-circle object-fit-cover me-3">
        @else
            <div class="rounded-circle bg-secondary me-3" style="width:100px; height:100px;"></div>
        @endif
        <h4 class="fw-bold">{{ $customer->first_name }} {{ $customer->last_name }}</h4>
    </div>

    <div class="row">
        <div class="col-md-6">
            <p><strong>Mobile:</strong> {{ $customer->mobile }}</p>
            <p><strong>Email:</strong> {{ $customer->email ?? '—' }}</p>
            <p><strong>City:</strong> {{ $customer->city }}</p>
            <p><strong>Country:</strong> {{ $customer->country }}</p>
        </div>
        <div class="col-md-6">
            <p><strong>Date of Birth:</strong> {{ $customer->dob ?? '—' }}</p>
            <p><strong>Zip Code:</strong> {{ $customer->zip ?? '—' }}</p>
            <p><strong>Permanent Address:</strong> {{ $customer->permanent_address ?? '—' }}</p>
        </div>
    </div>

    <hr>

    <h5>Passport / ID Info</h5>
    <p><strong>Nationality:</strong> {{ $customer->nationality }}</p>
    <p><strong>Passport No:</strong> {{ $customer->passport_no }}</p>
    <p><strong>Expiry:</strong> {{ $customer->passport_expiry }}</p>
    <p><strong>Age:</strong> {{ $customer->age }}</p>

    <hr>

    <h5>Emergency Contact</h5>
    <p><strong>Name:</strong> {{ $customer->emergency_name ?? '—' }}</p>
    <p><strong>Relation:</strong> {{ $customer->emergency_relation ?? '—' }}</p>
    <p><strong>City:</strong> {{ $customer->emergency_city ?? '—' }}</p>
    <p><strong>Phone:</strong> {{ $customer->emergency_phone ?? '—' }}</p>
    <p><strong>Address:</strong> {{ $customer->emergency_address ?? '—' }}</p>

    <hr>

    <h5>Driver License</h5>
    <p><strong>License No:</strong> {{ $customer->license_no ?? '—' }}</p>
    <p><strong>Country:</strong> {{ $customer->license_country ?? '—' }}</p>
    <p><strong>Expiry:</strong> {{ $customer->license_expiry ?? '—' }}</p>
    <p><strong>Intl. License No:</strong> {{ $customer->international_license_no ?? '—' }}</p>

    <hr>

    <h5>Payment Info</h5>
    <p><strong>Card Type:</strong> {{ $customer->card_type ?? '—' }}</p>
    <p><strong>Card Last 4:</strong> {{ $customer->card_last_four ?? '—' }}</p>
    <p><strong>Card Expiry:</strong> {{ $customer->card_expiry ?? '—' }}</p>
</div>

@endsection
