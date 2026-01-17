@extends('layouts.admin')

@section('title', 'Create Brand')
@section('page-title', 'Create Brand')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">

        <form method="POST" action="{{ route('brands.update', $brand->id) }}">
            @csrf
            @method('PUT')
            <input type="text" name="name" value="{{ old('name', $brand->name) }}" class="form-control" required>

            <div class="text-end pt-3">
                <a href="{{ route('brands.index') }}" class="btn btn-dark">Cancel</a>
                <button type="submit" class="btn btn-warning">Update Brand</button>
            </div>
        </form>


    </div>
</div>
@endsection
