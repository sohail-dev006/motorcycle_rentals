@extends('layouts.admin')

@section('title','Edit Customer')
@section('page-title','Edit Customer')

@section('content')

<form action="{{ route('customers.update', $customer) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- PERSONAL INFORMATION --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Personal Information</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">First Name *</label>
                    <input type="text" name="first_name" class="form-control" 
                           value="{{ old('first_name', $customer->first_name) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Last Name *</label>
                    <input type="text" name="last_name" class="form-control" 
                           value="{{ old('last_name', $customer->last_name) }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="dob" class="form-control" 
                           value="{{ old('dob', $customer->dob) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Zip Code</label>
                    <input type="text" name="zip" class="form-control" 
                           value="{{ old('zip', $customer->zip) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Mobile *</label>
                    <input type="text" name="mobile" class="form-control" 
                           value="{{ old('mobile', $customer->mobile) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" 
                           value="{{ old('email', $customer->email) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">City *</label>
                    <input type="text" name="city" class="form-control" 
                           value="{{ old('city', $customer->city) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Country *</label>
                    <select name="country" class="form-select" required>
                        <option value="">Select Country</option>
                        @foreach(['UAE','Pakistan','India','France'] as $country)
                            <option value="{{ $country }}" 
                                {{ old('country', $customer->country) == $country ? 'selected' : '' }}>
                                {{ $country }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Permanent Address</label>
                    <textarea name="permanent_address" class="form-control">{{ old('permanent_address', $customer->permanent_address) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    {{-- CUSTOMER IMAGE --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Customer Image</h5>

            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">

            @if($customer->image)
                <img id="preview" src="{{ asset('storage/'.$customer->image) }}" 
                     class="img-thumbnail mt-3" width="150">
            @else
                <img id="preview" class="img-thumbnail mt-3 d-none" width="150">
            @endif

            <button type="button" class="btn btn-sm btn-danger mt-2" id="removeBtn" onclick="removeImage()">
                Remove
            </button>
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
    const img = document.getElementById('preview');
    const btn = document.getElementById('removeBtn');
    img.src = URL.createObjectURL(e.target.files[0]);
    img.classList.remove('d-none');
    btn.classList.remove('d-none');
}

function removeImage(){
    document.querySelector('input[type=file]').value='';
    const img = document.getElementById('preview');
    const btn = document.getElementById('removeBtn');
    img.classList.add('d-none');
    img.src = '';
    btn.classList.add('d-none');
}
</script>
@endpush
