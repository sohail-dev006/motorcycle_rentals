@extends('layouts.admin')

@section('title', isset($tourBooking) ? 'Edit Tour Booking' : 'New Tour Booking')
@section('page-title', isset($tourBooking) ? 'Edit Booking' : 'Add New Booking')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">

        <h5 class="mb-3">Tour Booking Information</h5>

        <form action="{{ isset($tourBooking) ? route('tour-bookings.update', $tourBooking->id) : route('tour-bookings.store') }}" method="POST">
            @csrf
            @if(isset($tourBooking))
                @method('PUT')
            @endif

            <div class="row g-3">

                <div class="col-md-4">
                    <label class="form-label">Customer*</label>
                    <select name="customer_id" class="form-control" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ (old('customer_id', $tourBooking->customer_id ?? '') == $customer->id) ? 'selected' : '' }}>
                                {{ $customer->first_name }} {{ $customer->last_name }} ({{ $customer->mobile }})
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Pick Date*</label>
                    <input type="date" name="pick_date" class="form-control" required value="{{ old('pick_date', $tourBooking->pick_date ?? '') }}">
                    @error('pick_date')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Status*</label>
                    <select name="status" class="form-control">
                        @foreach(['pending','approved','cancelled'] as $status)
                            <option value="{{ $status }}" {{ (old('status', $tourBooking->status ?? '') == $status) ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tour*</label>
                    <select name="tour_id" class="form-control" required>
                        @foreach($tours as $tour)
                            <option value="{{ $tour->id }}" {{ (old('tour_id', $tourBooking->tour_id ?? '') == $tour->id) ? 'selected' : '' }}>
                                {{ $tour->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('tour_id')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Motorcycle</label>
                    <select name="motorcycle_id" class="form-control">
                        <option value="">Select</option>
                        @foreach($motorcycles as $m)
                            <option value="{{ $m->id }}" {{ (old('motorcycle_id', $tourBooking->motorcycle_id ?? '') == $m->id) ? 'selected' : '' }}>{{ $m->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label>Group Tour Price</label>
                    <input type="number" step="0.01" name="group_price" id="group" class="form-control calc"
                        value="{{ old('group_price', $tourBooking->group_price ?? '') }}">
                    @error('group_price')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="col-md-4">
                    <label>Private Tour Price</label>
                    <input type="number" step="0.01" name="private_price" id="private" class="form-control calc"
                        value="{{ old('private_price', $tourBooking->private_price ?? '') }}">
                    @error('private_price')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="col-md-4">
                    <label>Passenger Price</label>
                    <input type="number" step="0.01" name="passenger_price" id="passenger" class="form-control calc"
                        value="{{ old('passenger_price', $tourBooking->passenger_price ?? '') }}">
                    @error('passenger_price')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

            </div>

            <hr>

            <h6>Booking Summary</h6>
            <p>Subtotal: <strong id="subtotal">0</strong> AED</p>
            <p>5% VAT: <strong id="vat">0</strong> AED</p>
            <p>Total Price: <strong id="total">0</strong> AED</p>

            <div class="text-end">
                <button class="btn btn-warning px-5">Save Booking</button>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
const group = document.getElementById('group');
const priv = document.getElementById('private');
const passenger = document.getElementById('passenger');

function calculate() {
    let g = parseFloat(group.value) || 0;
    let p = parseFloat(priv.value) || 0;
    let ps = parseFloat(passenger.value) || 0;

    // Disable logic
    if(g>0) priv.disabled = true;
    else priv.disabled = false;

    if(p>0) group.disabled = true;
    else group.disabled = false;

    let subtotal = g + p + ps;
    let vat = subtotal * 0.05;
    let total = subtotal + vat;

    document.getElementById('subtotal').innerText = subtotal.toFixed(2);
    document.getElementById('vat').innerText = vat.toFixed(2);
    document.getElementById('total').innerText = total.toFixed(2);
}

// Initialize
[group, priv, passenger].forEach(i => i.addEventListener('input', calculate));
window.addEventListener('load', calculate);
</script>
@endpush
