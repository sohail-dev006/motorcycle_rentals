@extends('layouts.admin')

@section('title', 'Create Brand')
@section('page-title', 'Create Brand')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">

        <form method="POST" action="{{ route('brands.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Brand Name*</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="text-end">
                <a href="{{ route('brands.index') }}" class="btn btn-dark">Cancel</a>
                <button type="submit" class="btn btn-warning">Create Brand</button>
            </div>
        </form>

    </div>
</div>
@endsection
