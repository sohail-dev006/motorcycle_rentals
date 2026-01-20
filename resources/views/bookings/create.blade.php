@extends('layouts.admin')

@section('title','Add Booking')
@section('page-title','Add Booking')

@section('content')
<form method="POST" action="{{ route('bookings.store') }}">
    @csrf
    <div class="card p-3">
        <div class="mb-3">
            <label>Customer Name*</label>
            <select name="customer_id" class="form-control">
                <option value="">Select Customer</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}"
                        {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                        {{ $customer->first_name }} {{ $customer->last_name }}
                    </option>
                @endforeach
            </select>

            @error('customer_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror

        </div>

        <div class="mb-3">
            <label>Motorcycle*</label>
            <select name="motorcycle_id" class="form-control" required>
                <option value="">Select Motorcycle</option>
                @foreach($motorcycles as $motorcycle)
                    <option value="{{ $motorcycle->id }}">{{ $motorcycle->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Add-ons</label>
            <div class="d-flex gap-2 flex-wrap">
                @foreach($addons as $addon)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="addons[]" value="{{ $addon->name }}" id="addon{{ $addon->id }}">
                        <label class="form-check-label" for="addon{{ $addon->id }}">{{ $addon->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 mb-3">
                <label>Pick Date*</label>
                <input type="date" name="pick_date" class="form-control"
                    value="{{ old('pick_date') }}">

                @error('pick_date')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>
            <div class="col-md-3 mb-3">
                <label>Drop Date*</label>
                <input type="date" name="drop_date" class="form-control" required>
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

        <div class="mb-3">
            <label>Status*</label>
            <select name="status" class="form-control" required>
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>


        <div class="text-end">
            <a href="{{ route('bookings.index') }}" class="btn btn-dark">Cancel</a>
            <button type="submit" class="btn btn-warning">Save Booking</button>
        </div>
    </div>
</form>
@endsection
