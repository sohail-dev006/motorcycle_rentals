@extends('layouts.admin')

@section('title','Add Booking')
@section('page-title','Add Booking')

@section('content')
<form method="POST" action="{{ route('bookings.store') }}">
@csrf

<div class="card p-3">

    {{-- Customer --}}
    <div class="mb-3">
        <label>Customer*</label>
        <select name="customer_id" class="form-control" required>
            <option value="">Select Customer</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}">
                    {{ $customer->first_name }} {{ $customer->last_name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Motorcycle --}}
    <div class="mb-3">
        <label>Motorcycle*</label>
        <select name="motorcycle_id" id="motorcycle" class="form-control" required>
            <option value="">Select Motorcycle</option>
            @foreach($motorcycles as $motorcycle)
                <option value="{{ $motorcycle->id }}"
                    data-price="{{ $motorcycle->price_per_day }}">
                    {{ $motorcycle->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Addons --}}
    <div class="mb-3">
        <label>Add-ons</label>
        <div class="d-flex gap-3 flex-wrap">
            @foreach($addons as $addon)
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input addon"
                        data-price="{{ $addon->price }}"
                        name="addons[]"
                        value="{{ $addon->id }}">
                    <label class="form-check-label">
                        {{ $addon->name }} ({{ $addon->price }} AED)
                    </label>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Dates --}}
    <div class="row">
        <div class="col-md-3 mb-3">
            <label>Pick Date*</label>
            <input type="date" id="pick_date" name="pick_date" class="form-control" required>
        </div>

        <div class="col-md-3 mb-3">
            <label>Drop Date*</label>
            <input type="date" id="drop_date" name="drop_date" class="form-control" required>
        </div>

        <div class="col-md-3 mb-3">
            <label>Pick Time*</label>
            <input type="time" name="pick_time" class="form-control" required>
        </div>

        <div class="col-md-3 mb-3">
            <label>Drop Time*</label>
            <input type="time" name="drop_time" class="form-control" required>
        </div>
    </div>

    {{-- Status --}}
    <div class="mb-3">
        <label>Status*</label>
        <select name="status" class="form-control">
            <option value="pending">Pending</option>
            <option value="confirmed">Confirmed</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>

    {{-- Summary --}}
    <hr>
    <h6>Booking Summary</h6>
    <p>Days: <strong id="days">0</strong></p>
    <p>Subtotal: <strong id="subtotal">0.00</strong> AED</p>
    <p>VAT (5%): <strong id="vat">0.00</strong> AED</p>
    <p>Total: <strong id="total">0.00</strong> AED</p>

    <div class="text-end">
        <a href="{{ route('bookings.index') }}" class="btn btn-dark">Cancel</a>
        <button class="btn btn-warning">Save Booking</button>
    </div>

</div>
</form>
@endsection

@push('scripts')
<script>
const motorcycle = document.getElementById('motorcycle');
const pickDate = document.getElementById('pick_date');
const dropDate = document.getElementById('drop_date');
const addons = document.querySelectorAll('.addon');

function calculate() {
    let days = 0;
    let subtotal = 0;

    if (pickDate.value && dropDate.value) {
        const start = new Date(pickDate.value);
        const end = new Date(dropDate.value);
        days = Math.max(1, (end - start) / (1000 * 60 * 60 * 24));
    }

    // Motorcycle price
    const bikePrice = motorcycle.selectedOptions[0]?.dataset.price || 0;
    subtotal += bikePrice * days;

    // Addons price
    addons.forEach(a => {
        if (a.checked) {
            subtotal += parseFloat(a.dataset.price);
        }
    });

    const vat = subtotal * 0.05;
    const total = subtotal + vat;

    document.getElementById('days').innerText = days;
    document.getElementById('subtotal').innerText = subtotal.toFixed(2);
    document.getElementById('vat').innerText = vat.toFixed(2);
    document.getElementById('total').innerText = total.toFixed(2);
}

[motorcycle, pickDate, dropDate].forEach(e => e.addEventListener('change', calculate));
addons.forEach(a => a.addEventListener('change', calculate));
</script>
@endpush
