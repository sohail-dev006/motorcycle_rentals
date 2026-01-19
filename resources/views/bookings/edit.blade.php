@extends('layouts.admin')

@section('title','Edit Booking')
@section('page-title','Edit Booking')

@section('content')
<form method="POST" action="{{ route('bookings.update', $booking) }}">
    @csrf
    @method('PUT')
    <div class="card p-3">
        <div class="mb-3">
            <label>Customer Name*</label>
            <select name="customer_id" class="form-control" required>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ $booking->customer_id == $customer->id ? 'selected' : '' }}>
                        {{ $customer->first_name }} {{ $customer->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Motorcycle*</label>
            <select name="motorcycle_id" class="form-control" required>
                @foreach($motorcycles as $motorcycle)
                    <option value="{{ $motorcycle->id }}" {{ $booking->motorcycle_id == $motorcycle->id ? 'selected' : '' }}>
                        {{ $motorcycle->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Add-ons</label>
            <div class="d-flex gap-2 flex-wrap">
                @foreach($addons as $addon)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="addons[]" value="{{ $addon->name }}" id="addon{{ $addon->id }}"
                        {{ in_array($addon->name, $booking->addons ?? []) ? 'checked' : '' }}>
                        <label class="form-check-label" for="addon{{ $addon->id }}">{{ $addon->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 mb-3">
                <label>Pick Date*</label>
                <input type="date" name="pick_date" class="form-control" value="{{ $booking->pick_date->format('Y-m-d') }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Drop Date*</label>
                <input type="date" name="drop_date" class="form-control" value="{{ $booking->drop_date->format('Y-m-d') }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Pick Time*</label>
                <input type="time" name="pick_time" class="form-control" value="{{ $booking->pick_time }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Drop Time*</label>
                <input type="time" name="drop_time" class="form-control" value="{{ $booking->drop_time }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Status*</label>
            <select name="status" class="form-control" required>
                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3">{{ $booking->description }}</textarea>
        </div>

        <div class="text-end">
            <a href="{{ route('bookings.index') }}" class="btn btn-dark">Cancel</a>
            <button type="submit" class="btn btn-warning">Update Booking</button>
        </div>
    </div>
</form>
@endsection
