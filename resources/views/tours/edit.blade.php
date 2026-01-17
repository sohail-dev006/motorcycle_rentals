@extends('layouts.admin')

@section('title', 'Edit Tour')
@section('page-title', 'Edit Tour')

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

<form method="POST" action="{{ route('tours.update', $tour->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h6 class="fw-bold mb-3">Tour Information</h6>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Tour Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $tour->name) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select">
                        <option value="featured" {{ old('status', $tour->status)=='featured' ? 'selected' : '' }}>Featured</option>
                        <option value="unfeatured" {{ old('status', $tour->status)=='unfeatured' ? 'selected' : '' }}>Unfeatured</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Group Tour Price *</label>
                    <input type="number" step="0.01" name="group_price" class="form-control" value="{{ old('group_price', $tour->group_price) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Private Tour Price *</label>
                    <input type="number" step="0.01" name="private_price" class="form-control" value="{{ old('private_price', $tour->private_price) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Passenger Price *</label>
                    <input type="number" step="0.01" name="passenger_price" class="form-control" value="{{ old('passenger_price', $tour->passenger_price) }}">
                </div>

                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $tour->description) }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    @if($tour->image)
                        <div class="mt-3" style="max-width: 200px;">
                            <img src="{{ asset('storage/'.$tour->image) }}" class="img-thumbnail w-100">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="text-end">
        <a href="{{ route('tours.index') }}" class="btn btn-dark px-5 rounded-pill">Cancel</a>
        <button type="submit" class="btn btn-warning px-5 rounded-pill">Update Tour</button>
    </div>
</form>

@endsection
