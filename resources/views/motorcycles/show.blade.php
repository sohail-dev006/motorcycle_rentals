@extends('layouts.admin')

@section('title', 'View Motorcycle')
@section('page-title', 'Motorcycle Details')

@section('content')

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">{{ $motorcycle->name }}</h4>
                <small class="text-muted">Motorcycle details</small>
            </div>

            <a href="{{ route('motorcycles.index') }}" class="btn btn-dark">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>

        {{-- Motorcycle Details --}}
        <div class="row">
            {{-- Image --}}
            <div class="col-md-4 text-center mb-3">
                <img src="{{ $motorcycle->image ? asset('storage/'.$motorcycle->image) : asset('images/no-image.png') }}"
                     class="img-fluid rounded shadow-sm"
                     alt="{{ $motorcycle->name }}">
            </div>

            {{-- Info --}}
            <div class="col-md-8">
                <p><strong>Code:</strong> {{ $motorcycle->code }}</p>
                <p><strong>Status:</strong> {{ ucfirst($motorcycle->status) }}</p>
                <p><strong>Visibility:</strong> {{ ucfirst($motorcycle->visibility) }}</p>
                <p><strong>Sort Order:</strong> {{ $motorcycle->sort_order }}</p>
                <p><strong>Base Price:</strong> AED {{ number_format($motorcycle->base_price, 2) }}</p>
                <p><strong>Extra Price:</strong> AED {{ number_format($motorcycle->extra_price, 2) }}</p>

                <hr>

                <h5>Description</h5>
                <div>{!! $motorcycle->description !!}</div>

                {{-- Action Buttons --}}
                <div class="mt-4 d-flex gap-2">
                    <a href="{{ route('motorcycles.edit', $motorcycle->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>

                    <form action="{{ route('motorcycles.destroy', $motorcycle->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Delete this Motorcycle?')" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection
