@extends('layouts.admin')

@section('title', 'Show Add On')
@section('page-title', 'Add On Details')

@section('content')

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">{{ $addon->name }}</h4>
                <small class="text-muted">Details of this Add On</small>
            </div>

            <a href="{{ route('add.index') }}" class="btn btn-dark">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>

        {{-- Add On Details --}}
        <div class="row">
            <div class="col-md-4 text-center mb-3">
                <img src="{{ $addon->image ? asset('storage/'.$addon->image) : asset('images/no-image.png') }}"
                     class="img-fluid rounded shadow-sm"
                     alt="{{ $addon->name }}">
            </div>

            <div class="col-md-8">
                <h5 class="mb-2">Name</h5>
                <p>{{ $addon->name }}</p>

                <h5 class="mb-2">Price</h5>
                <p>AED {{ number_format($addon->price, 2) }}</p>

                <h5 class="mb-2">Description</h5>
                <p>{!! nl2br(e($addon->description)) !!}</p>

                <div class="mt-3">
                    <a href="{{ route('add.edit', $addon->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <form action="{{ route('add.destroy', $addon->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Delete this Add On?')" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
