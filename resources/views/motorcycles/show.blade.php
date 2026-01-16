@extends('layouts.admin')

@section('title', 'View Motorcycle')
@section('page-title', 'View Motorcycle')

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-body">
        <h4 class="mb-3">{{ $motorcycle->name }}</h4>

        <p><strong>Code:</strong> {{ $motorcycle->code }}</p>
        <p><strong>Status:</strong> {{ ucfirst($motorcycle->status) }}</p>
        <p><strong>Visibility:</strong> {{ ucfirst($motorcycle->visibility) }}</p>
        <p><strong>Sort Order:</strong> {{ $motorcycle->sort_order }}</p>
        <p><strong>Base Price:</strong> AED {{ $motorcycle->base_price }}</p>
        <p><strong>Extra Price:</strong> AED {{ $motorcycle->extra_price }}</p>

        <hr>

        <div>{!! $motorcycle->description !!}</div>

        @if($motorcycle->image)
            <img src="{{ asset('storage/'.$motorcycle->image) }}" class="img-fluid mt-3" width="300">
        @endif

        <div class="mt-4">
            <a href="{{ route('motorcycles.index') }}" class="btn btn-dark">
                Back
            </a>
        </div>
    </div>
</div>

@endsection
