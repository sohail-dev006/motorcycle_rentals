@extends('layouts.admin')

@section('title','Edit Booking')
@section('page-title','Edit Booking')

@section('content')
<form method="POST" action="{{ route('bookings.update', $booking) }}">
    @csrf
    @method('PUT')

    <div class="card p-4 shadow-sm border-0">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Edit Booking</h4>
            <a href="{{ route('bookings.index') }}" class="btn btn-secondary rounded-pill">
                <i class="fa fa-arrow-left me-1"></i> Back
            </a>
        </div>

        {{-- Customer --}}
        <div class="mb-3">
            <label>Customer*</label>
            <select name="customer_id" class="form-control" required>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ $booking->customer_id == $customer->id ? 'selected' : '' }}>
                        {{ $customer->first_name }} {{ $customer->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Motorcycle --}}
        <div class="mb-3">
            <label>Motorcycle*</label>
            <select name="motorcycle_id" id="motorcycle" class="form-control" required>
                @foreach($motorcycles as $motorcycle)
                    <option value="{{ $motorcycle->id }}" 
                            data-price="{{ $motorcycle->price }}" 
                            {{ $booking->motorcycle_id == $motorcycle->id ? 'selected' : '' }}>
                        {{ $motorcycle->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Add-ons --}}
        <div class="mb-3">
            <label>Add-ons</label>
            <div class="d-flex gap-2 flex-wrap">
                @foreach($addons as $addon)
                    <div class="form-check">
                        <input class="form-check-input addon" type="checkbox" name="addons[]" 
                               value="{{ $addon->name }}" 
                               id="addon{{ $addon->id }}"
                               data-price="{{ $addon->price ?? 0 }}"
                               {{ in_array($addon->name, $booking->addons ?? []) ? 'checked' : '' }}>
                        <label class="form-check-label" for="addon{{ $addon->id }}">{{ $addon->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Pick / Drop Dates & Times --}}
        <div class="row mb-3">
            <div class="col-md-3">
                <label>Pick Date*</label>
                <input type="date" name="pick_date" class="form-control" 
                       value="{{ $booking->pick_date->format('Y-m-d') }}" required>
            </div>
            <div class="col-md-3">
                <label>Drop Date*</label>
                <input type="date" name="drop_date" class="form-control" 
                       value="{{ $booking->drop_date->format('Y-m-d') }}" required>
            </div>
            <div class="col-md-3">
                <label>Pick Time*</label>
                <input type="time" name="pick_time" class="form-control" value="{{ $booking->pick_time }}" required>
            </div>
            <div class="col-md-3">
                <label>Drop Time*</label>
                <input type="time" name="drop_time" class="form-control" value="{{ $booking->drop_time }}" required>
            </div>
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label>Status*</label>
            <select name="status" class="form-control" required>
                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3">{{ $booking->description }}</textarea>
        </div>

        {{-- Booking Summary --}}
        <hr>
        <h6 class="fw-bold">Booking Summary</h6>
        <div class=" mb-3">
            <div class="d-flex">
                <p class="text-muted pe-2 mb-1">Days :</p>
                <p class="fw-semibold" id="days">0</p>
            </div>
            <div class="d-flex">
                <p class="text-muted pe-2 mb-1">Motorcycle Price :</p>
                <p class="fw-semibold" id="bike_price">0</p>
            </div>
            <div class="d-flex">
                <p class="text-muted pe-2 mb-1">Subtotal :</p>
                <p class="fw-semibold" id="subtotal">0.00 AED</p>
            </div>
            <div class="d-flex">
                <p class="text-muted pe-2 mb-1">VAT (5%) :</p>
                <p class="fw-semibold" id="vat">0.00 AED</p>
            </div>
            <div class="d-flex">
                <p class="text-muted pe-2 mb-1">Total :</p>
                <p class="fw-semibold" id="total">0.00 AED</p>
            </div>
        </div>

        {{-- Submit --}}
        <div class="text-end">
            <a href="{{ route('bookings.index') }}" class="btn btn-dark">Cancel</a>
            <button type="submit" class="btn btn-warning">Update Booking</button>
        </div>

    </div>
</form>
@endsection

@push('scripts')
<script>
const motorcycle = document.getElementById('motorcycle');
const pickDate = document.querySelector('input[name="pick_date"]');
const dropDate = document.querySelector('input[name="drop_date"]');
const pickTime = document.querySelector('input[name="pick_time"]');
const dropTime = document.querySelector('input[name="drop_time"]');
const addons = document.querySelectorAll('.addon');

function calculate() {
    let days = 0;
    let subtotal = 0;

    if (pickDate.value && dropDate.value && pickTime.value && dropTime.value) {
        const pick = new Date(pickDate.value + 'T' + pickTime.value);
        const drop = new Date(dropDate.value + 'T' + dropTime.value);
        const hours = (drop - pick) / (1000 * 60 * 60);
        days = hours > 0 ? Math.max(1, Math.ceil(hours / 24)) : 1;
    }

    const bikePrice = parseFloat(motorcycle.selectedOptions[0]?.dataset.price) || 0;
    subtotal += bikePrice * days;

    addons.forEach(a => {
        if(a.checked) subtotal += parseFloat(a.dataset.price);
    });

    const vat = subtotal * 0.05;
    const total = subtotal + vat;

    document.getElementById('days').innerText = days;
    document.getElementById('bike_price').innerText = bikePrice;
    document.getElementById('subtotal').innerText = subtotal.toFixed(2) + ' AED';
    document.getElementById('vat').innerText = vat.toFixed(2) + ' AED';
    document.getElementById('total').innerText = total.toFixed(2) + ' AED';
}

// Event listeners
[motorcycle, pickDate, dropDate, pickTime, dropTime].forEach(e => e.addEventListener('change', calculate));
addons.forEach(a => a.addEventListener('change', calculate));

// Calculate on page load
window.addEventListener('DOMContentLoaded', calculate);
</script>
@endpush
