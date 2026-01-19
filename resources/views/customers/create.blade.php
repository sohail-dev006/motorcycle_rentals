@extends('layouts.admin')

@section('title','Add Customer')
@section('page-title','Add New Customer')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
@csrf

{{-- PERSONAL INFORMATION --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h5 class="fw-bold mb-3">Personal Information</h5>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">First Name *</label>
                <input type="text" name="first_name" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Last Name *</label>
                <input type="text" name="last_name" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Date of Birth</label>
                <input type="date" name="dob" class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">Zip Code</label>
                <input type="text" name="zip" class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">Mobile *</label>
                <input type="text" name="mobile" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">City *</label>
                <input type="text" name="city" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Country *</label>
                <select name="country" class="form-select" required>
                    <option value="">Select Country</option>
                    <option>UAE</option>
                    <option>Pakistan</option>
                    <option>India</option>
                    <option>France</option>
                </select>
            </div>

            <div class="col-12">
                <label class="form-label">Permanent Address</label>
                <textarea name="permanent_address" class="form-control"></textarea>
            </div>
        </div>
    </div>
</div>

{{-- VISITOR ADDRESS --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h5 class="fw-bold mb-3">Visitors Address Information</h5>

        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Hotel Name</label>
                <input type="text" name="hotel_name" class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">Room No</label>
                <input type="text" name="room_no" class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">City</label>
                <input type="text" name="visitor_city" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">Hotel Phone No</label>
                <input type="text" name="visitor_phone" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">UAE City</label>
                <input type="text" name="uae_city" class="form-control">
            </div>

            <div class="col-12">
                <label class="form-label">UAE Address / Location</label>
                <textarea name="uae_address" class="form-control"></textarea>
            </div>
        </div>
    </div>
</div>

{{-- PASSPORT --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h5 class="fw-bold mb-3">Passport / ID Information</h5>

        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Nationality *</label>
                <input type="text" name="nationality" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Passport No *</label>
                <input type="text" name="passport_no" class="form-control" required>
            </div>

            <div class="col-md-2">
                <label class="form-label">Expiry Date *</label>
                <input type="date" name="passport_expiry" class="form-control" required>
            </div>

            <div class="col-md-2">
                <label class="form-label">Age *</label>
                <input type="number" name="age" class="form-control" required>
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
                <label class="form-label">Name (not riding with you)</label>
                <input type="text" name="emergency_name" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">Relationship</label>
                <input type="text" name="emergency_relation" class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">City</label>
                <input type="text" name="emergency_city" class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">Phone</label>
                <input type="text" name="emergency_phone" class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">Address</label>
                <input type="text" name="emergency_address" class="form-control">
            </div>
        </div>
    </div>
</div>

{{-- DRIVER LICENSE --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h5 class="fw-bold mb-3">Driver’s License</h5>

        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">License No</label>
                <input type="text" name="license_no" class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">Country Issued In</label>
                <input type="text" name="license_country" class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">Expiry Date</label>
                <input type="date" name="license_expiry" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">International Driving License No</label>
                <input type="text" name="international_license_no" class="form-control">
            </div>
        </div>
    </div>
</div>

{{-- PAYMENT --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h5 class="fw-bold mb-3">Payment Detail</h5>

        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Card Type *</label>
                <select name="card_type" class="form-select">
                    <option value="">Select Card Type</option>
                    <option>Visa</option>
                    <option>Master</option>
                    <option>Amex</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Card Number *</label>
                <input type="text" name="card_number" class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">Expiry Date (MM/YY)</label>
                <input type="text" name="card_expiry" class="form-control">
            </div>
        </div>
    </div>
</div>

{{-- IMAGE --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h5 class="fw-bold mb-3">Customer Image</h5>

        <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
        <img id="preview" class="img-thumbnail mt-3 d-none" width="150">
        <button type="button" class="btn btn-sm btn-danger mt-2 d-none" id="removeBtn" onclick="removeImage()">Remove</button>
    </div>
</div>

<div class="text-end">
    <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
    <button class="btn btn-warning px-4">Save Customer</button>
</div>

</form>

@endsection

@push('scripts')
<script>
function previewImage(e){
    const img = document.getElementById('preview');
    const btn = document.getElementById('removeBtn');
    img.src = URL.createObjectURL(e.target.files[0]);
    img.classList.remove('d-none');
    btn.classList.remove('d-none');
}
function removeImage(){
    document.querySelector('input[type=file]').value='';
    document.getElementById('preview').classList.add('d-none');
    document.getElementById('removeBtn').classList.add('d-none');
}
</script>
@endpush
