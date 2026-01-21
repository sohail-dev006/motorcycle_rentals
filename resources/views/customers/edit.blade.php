@extends('layouts.admin')

@section('title','Edit Customer')
@section('page-title','Edit Customer')

@section('content')

{{-- ERRORS --}}
@if ($errors->any())
    <div class="alert alert-danger" id="errorAlert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('customers.update', $customer) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

{{-- PERSONAL INFORMATION --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h5 class="fw-bold mb-3">Personal Information</h5>
        <div class="row g-3">

            <div class="col-md-6">
                <label>First Name *</label>
                <input type="text" name="first_name" class="form-control"
                    value="{{ old('first_name', $customer->first_name) }}" required>
            </div>

            <div class="col-md-6">
                <label>Last Name *</label>
                <input type="text" name="last_name" class="form-control"
                    value="{{ old('last_name', $customer->last_name) }}" required>
            </div>

            <div class="col-md-4">
                <label>DOB</label>
                <input type="date" name="dob" class="form-control"
                    value="{{ old('dob', $customer->dob) }}">
            </div>

            <div class="col-md-4">
                <label>Zip</label>
                <input type="text" name="zip" class="form-control"
                    value="{{ old('zip', $customer->zip) }}">
            </div>

            <div class="col-md-4">
                <label>Mobile *</label>
                <input type="text" name="mobile" class="form-control"
                    value="{{ old('mobile', $customer->mobile) }}" required>
            </div>

            <div class="col-md-6">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                    value="{{ old('email', $customer->email) }}">
            </div>

            <div class="col-md-6">
                <label>City *</label>
                <input type="text" name="city" class="form-control"
                    value="{{ old('city', $customer->city) }}" required>
            </div>

            <div class="col-md-6">
                <label>Country *</label>
                <select name="country" class="form-select" required>
                    @foreach(['UAE','Pakistan','India','France'] as $c)
                        <option value="{{ $c }}"
                            {{ old('country', $customer->country) == $c ? 'selected' : '' }}>
                            {{ $c }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-12">
                <label>Permanent Address</label>
                <textarea name="permanent_address" class="form-control">{{ old('permanent_address', $customer->permanent_address) }}</textarea>
            </div>

        </div>
    </div>
</div>

{{-- VISITOR ADDRESS --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h5 class="fw-bold mb-3">Visitor Address</h5>
        <div class="row g-3">

            <div class="col-md-4">
                <label>Hotel Name</label>
                <input type="text" name="hotel_name" class="form-control"
                    value="{{ old('hotel_name', $customer->hotel_name) }}">
            </div>

            <div class="col-md-4">
                <label>Room No</label>
                <input type="text" name="room_no" class="form-control"
                    value="{{ old('room_no', $customer->room_no) }}">
            </div>

            <div class="col-md-4">
                <label>Visitor City</label>
                <input type="text" name="visitor_city" class="form-control"
                    value="{{ old('visitor_city', $customer->visitor_city) }}">
            </div>

            <div class="col-md-6">
                <label>Visitor Phone</label>
                <input type="text" name="visitor_phone" class="form-control"
                    value="{{ old('visitor_phone', $customer->visitor_phone) }}">
            </div>

            <div class="col-md-6">
                <label>UAE City</label>
                <input type="text" name="uae_city" class="form-control"
                    value="{{ old('uae_city', $customer->uae_city) }}">
            </div>

            <div class="col-12">
                <label>UAE Address</label>
                <textarea name="uae_address" class="form-control">{{ old('uae_address', $customer->uae_address) }}</textarea>
            </div>

        </div>
    </div>
</div>

{{-- PASSPORT --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h5 class="fw-bold mb-3">Passport / ID</h5>
        <div class="row g-3">

            <div class="col-md-4">
                <label>Nationality</label>
                <input type="text" name="nationality" class="form-control"
                    value="{{ old('nationality', $customer->nationality) }}">
            </div>

            <div class="col-md-4">
                <label>Passport No</label>
                <input type="text" name="passport_no" class="form-control"
                    value="{{ old('passport_no', $customer->passport_no) }}">
            </div>

            <div class="col-md-2">
                <label>Expiry</label>
                <input type="date" name="passport_expiry"
                    value="{{ old('passport_expiry', optional($customer->passport_expiry)->format('Y-m-d')) }}"
                    class="form-control">

            </div>

            <div class="col-md-2">
                <label>Age</label>
                <input type="number" name="age" class="form-control"
                    value="{{ old('age', $customer->age) }}">
            </div>

        </div>
    </div>
</div>

{{-- EMERGENCY --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h5 class="fw-bold mb-3">Emergency Contact</h5>
        <div class="row g-3">

            <div class="col-md-6">
                <label>Name</label>
                <input type="text" name="emergency_name" class="form-control"
                    value="{{ old('emergency_name', $customer->emergency_name) }}">
            </div>

            <div class="col-md-6">
                <label>Relation</label>
                <input type="text" name="emergency_relation" class="form-control"
                    value="{{ old('emergency_relation', $customer->emergency_relation) }}">
            </div>

            <div class="col-md-4">
                <label>City</label>
                <input type="text" name="emergency_city" class="form-control"
                    value="{{ old('emergency_city', $customer->emergency_city) }}">
            </div>

            <div class="col-md-4">
                <label>Phone</label>
                <input type="text" name="emergency_phone" class="form-control"
                    value="{{ old('emergency_phone', $customer->emergency_phone) }}">
            </div>

            <div class="col-md-4">
                <label>Address</label>
                <input type="text" name="emergency_address" class="form-control"
                    value="{{ old('emergency_address', $customer->emergency_address) }}">
            </div>

        </div>
    </div>
</div>

{{-- IMAGE --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h5 class="fw-bold mb-3">Customer Image</h5>

        <input type="file" name="image" class="form-control" onchange="previewImage(event)">
        @if($customer->image)
            <img id="preview" src="{{ asset('storage/'.$customer->image) }}" class="img-thumbnail mt-3" width="150">
        @else
            <img id="preview" class="img-thumbnail mt-3 d-none" width="150">
        @endif
        <button type="button" class="btn btn-sm btn-danger mt-2" id="removeBtn" onclick="removeImage()">Remove</button>
    </div>
</div>

<div class="text-end">
    <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
    <button class="btn btn-warning px-4">Update Customer</button>
</div>

</form>
@endsection

@push('scripts')
<script>
function previewImage(e){
    preview.src = URL.createObjectURL(e.target.files[0]);
    preview.classList.remove('d-none');
}
function removeImage(){
    document.querySelector('input[type=file]').value='';
    preview.classList.add('d-none');
}
setTimeout(() => {
    const a = document.getElementById('errorAlert');
    if (a) a.remove();
}, 3000);
</script>
@endpush
