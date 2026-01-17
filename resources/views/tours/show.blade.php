@extends('layouts.admin')

@section('title', 'Tour Details')
@section('page-title', 'Tour Details')

@section('content')

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4>{{ $tour->name }}</h4>
                <small class="text-muted">Tour details</small>
            </div>
            <a href="{{ route('tours.index') }}" class="btn btn-dark">Back to List</a>
        </div>

        <div class="row">
            <div class="col-md-4 text-center mb-3">
                <img src="{{ $tour->image ? asset('storage/'.$tour->image) : asset('images/no-image.png') }}"
                     class="img-fluid rounded shadow-sm" alt="{{ $tour->name }}">
            </div>

            <div class="col-md-8">
                <p><strong>Status:</strong> {{ ucfirst($tour->status) }}</p>
                <p><strong>Group Price:</strong> AED {{ number_format($tour->group_price, 2) }}</p>
                <p><strong>Private Price:</strong> AED {{ number_format($tour->private_price, 2) }}</p>
                <p><strong>Passenger Price:</strong> AED {{ number_format($tour->passenger_price, 2) }}</p>

                <hr>

                <h5>Description</h5>
                <div>{!! $tour->description !!}</div>

                <div class="mt-4 d-flex gap-2">
                    <a href="{{ route('tours.edit', $tour->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>

                    <form action="{{ route('tours.destroy', $tour->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Delete this tour?')" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection
