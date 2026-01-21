@extends('layouts.admin')

@section('title', isset($tourBooking) ? 'Edit Tour Booking' : 'New Tour Booking')
@section('page-title', isset($tourBooking) ? 'Edit Booking' : 'Add New Booking')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">

        <h5 class="mb-3">Tour Booking Information</h5>

        <form action="{{ isset($tourBooking) ? route('tour-bookings.update', $tourBooking->id) : route('tour-bookings.store') }}" method="POST">
            @csrf
            @isset($tourBooking)
                @method('PUT')
            @endisset

            <div class="row g-3">

                {{-- Customer --}}
                <div class="col-md-4">
                    <label class="form-label">Customer*</label>
                    <select name="customer_id" class="form-control" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}"
                                {{ old('customer_id', $tourBooking->customer_id ?? '') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->first_name }} {{ $customer->last_name }} ({{ $customer->mobile }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Pick Date --}}
                <div class="col-md-4">
                    <label class="form-label">Pick Date*</label>
                    <input type="date" name="pick_date" class="form-control" required
                        value="{{ old('pick_date', $tourBooking->pick_date ?? '') }}">
                </div>

                {{-- Status --}}
                <div class="col-md-4">
                    <label class="form-label">Status*</label>
                    <select name="status" class="form-control">
                        @foreach(['pending','approved','cancelled'] as $status)
                            <option value="{{ $status }}"
                                {{ old('status', $tourBooking->status ?? '') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tour --}}
                <div class="col-md-6">
                    <label class="form-label">Tour*</label>
                    <select name="tour_id" id="tour" class="form-control" required>
                        <option value="">Select Tour</option>
                        @foreach($tours as $tour)
                            <option value="{{ $tour->id }}"
                                data-group="{{ $tour->group_price }}"
                                data-private="{{ $tour->private_price }}"
                                data-passenger="{{ $tour->passenger_price }}"
                                {{ old('tour_id', $tourBooking->tour_id ?? '') == $tour->id ? 'selected' : '' }}>
                                {{ $tour->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Motorcycle --}}
                <div class="col-md-6">
                    <label class="form-label">Motorcycle</label>
                    <select name="motorcycle_id" class="form-control">
                        <option value="">Select</option>
                        @foreach($motorcycles as $m)
                            <option value="{{ $m->id }}"
                                {{ old('motorcycle_id', $tourBooking->motorcycle_id ?? '') == $m->id ? 'selected' : '' }}>
                                {{ $m->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Prices --}}
                <div class="col-md-4">
                    <label>Group Tour Price</label>
                    <input type="number" step="0.01" name="group_price" id="group"
                        class="form-control calc"
                        value="{{ old('group_price', $tourBooking->group_price ?? 0) }}">
                </div>

                <div class="col-md-4">
                    <label>Private Tour Price</label>
                    <input type="number" step="0.01" name="private_price" id="private"
                        class="form-control calc"
                        value="{{ old('private_price', $tourBooking->private_price ?? 0) }}">
                </div>

                <div class="col-md-4">
                    <label>Passenger Price</label>
                    <input type="number" step="0.01" name="passenger_price" id="passenger"
                        class="form-control calc"
                        value="{{ old('passenger_price', $tourBooking->passenger_price ?? 0) }}">
                </div>

            </div>

            <hr>

            {{-- Summary --}}
            <h6>Booking Summary</h6>
            <p>Subtotal: <strong id="subtotal">0.00</strong> AED</p>
            <p>5% VAT: <strong id="vat">0.00</strong> AED</p>
            <p>Total Price: <strong id="total">0.00</strong> AED</p>

            <div class="text-end">
                <button class="btn btn-warning px-5">Save Booking</button>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
const tourSelect = document.getElementById('tour');
const group = document.getElementById('group');
const priv = document.getElementById('private');
const passenger = document.getElementById('passenger');

function calculate() {
    let g = parseFloat(group.value) || 0;
    let p = parseFloat(priv.value) || 0;
    let ps = parseFloat(passenger.value) || 0;

    priv.disabled = g > 0;
    group.disabled = p > 0;

    let subtotal = g + p + ps;
    let vat = subtotal * 0.05;
    let total = subtotal + vat;

    document.getElementById('subtotal').innerText = subtotal.toFixed(2);
    document.getElementById('vat').innerText = vat.toFixed(2);
    document.getElementById('total').innerText = total.toFixed(2);
}

// Tour change → auto prices
tourSelect.addEventListener('change', function () {
    const opt = this.options[this.selectedIndex];
    group.value = opt.dataset.group || 0;
    priv.value = opt.dataset.private || 0;
    passenger.value = opt.dataset.passenger || 0;
    calculate();
});

// Init
[group, priv, passenger].forEach(el => el.addEventListener('input', calculate));
window.addEventListener('load', calculate);
</script>
@endpush
