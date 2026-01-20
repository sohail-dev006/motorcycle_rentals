@extends('layouts.admin')

@section('title','Edit Tour Booking')
@section('page-title','Edit Booking')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">

        <h5 class="mb-3">Tour Booking Information</h5>

        <form action="{{ route('tour-bookings.update', $tourBooking->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">

                {{-- Customer --}}
                <div class="col-md-4">
                    <label class="form-label">Customer*</label>
                    <select name="customer_id" class="form-control" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" 
                                {{ $tourBooking->customer_id == $customer->id ? 'selected' : '' }}>
                                {{ $customer->first_name }} {{ $customer->last_name }}
                                ({{ $customer->mobile }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Pick Date --}}
                <div class="col-md-4">
                    <label class="form-label">Pick Date*</label>
                    <input type="date" name="pick_date" class="form-control" 
                        value="{{ $tourBooking->pick_date }}" required>
                </div>

                {{-- Status --}}
                <div class="col-md-4">
                    <label class="form-label">Status*</label>
                    <select name="status" class="form-control">
                        <option value="pending" {{ $tourBooking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $tourBooking->status == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="cancelled" {{ $tourBooking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                {{-- Tour --}}
                <div class="col-md-6">
                    <label class="form-label">Tour*</label>
                    <select name="tour_id" class="form-control" required>
                        @foreach($tours as $tour)
                            <option value="{{ $tour->id }}" 
                                {{ $tourBooking->tour_id == $tour->id ? 'selected' : '' }}>
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
                                {{ $tourBooking->motorcycle_id == $m->id ? 'selected' : '' }}>
                                {{ $m->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Prices --}}
                <div class="col-md-4">
                    <label>Group Tour Price</label>
                    <input type="number" step="0.01" name="group_price" id="group" 
                        class="form-control calc" value="{{ $tourBooking->group_price }}">
                </div>

                <div class="col-md-4">
                    <label>Private Tour Price</label>
                    <input type="number" step="0.01" name="private_price" id="private" 
                        class="form-control calc" value="{{ $tourBooking->private_price }}">
                </div>

                <div class="col-md-4">
                    <label>Passenger Price</label>
                    <input type="number" step="0.01" name="passenger_price" id="passenger" 
                        class="form-control calc" value="{{ $tourBooking->passenger_price }}">
                </div>

            </div>

            <hr>

            {{-- Booking Summary --}}
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
const privateInput = document.getElementById('private');
const passenger = document.getElementById('passenger');

function calculate() {
    let g = parseFloat(group.value) || 0;
    let p = parseFloat(privateInput.value) || 0;
    let ps = parseFloat(passenger.value) || 0;

    let subtotal = g + p + ps;
    let vat = subtotal * 0.05;
    let total = subtotal + vat;

    document.getElementById('subtotal').innerText = subtotal.toFixed(2);
    document.getElementById('vat').innerText = vat.toFixed(2);
    document.getElementById('total').innerText = total.toFixed(2);
}

// Initial calculation on page load
calculate();

// Event listeners
[group, privateInput, passenger].forEach(i => i.addEventListener('input', calculate));
</script>
@endpush
