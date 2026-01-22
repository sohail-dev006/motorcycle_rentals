@extends('layouts.admin')

@section('title','Tour Bookings')
@section('page-title','Tour Bookings')

@section('content')

@if(session('success'))
<div class="alert alert-success" id="successAlert">{{ session('success') }}</div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <h4 class="mb-1">Tour Bookings</h4>
                <small class="text-muted">Manage Tour Bookings</small>
            </div>

            <a href="{{ route('tour-bookings.create') }}" class="btn btn-warning mb-3">
                + Add Tour Booking
            </a>
        </div>

        {{-- Desktop Table --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Tour Image</th>
                        <th>Customer</th>
                        <th>Tour</th>
                        <th>Pick Date</th>
                        <th>Status</th>
                        <th>Total (AED)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $b)
                    <tr>
                        <td>
                            <img src="{{ $b->tour->image ? asset('storage/'.$b->tour->image) : asset('images/no-image.png') }}"
                                 alt="{{ $b->tour->name }}" width="60" class="rounded">
                        </td>
                        <td>{{ $b->customer->first_name }} {{ $b->customer->last_name }}</td>
                        <td>{{ $b->tour->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($b->pick_date)->format('d-m-Y') }}</td>
                        <td>
                            <span class="badge {{ $b->status === 'approved' ? 'bg-success' : ($b->status === 'cancelled' ? 'bg-danger' : 'bg-warning') }}">
                                {{ ucfirst($b->status) }}
                            </span>
                        </td>
                        <td>{{ number_format($b->total_price, 2) }}</td>
                        <td class="d-flex gap-1">
                            <a href="{{ route('tour-bookings.show', $b->id) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('tour-bookings.edit', $b->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('tour-bookings.destroy', $b->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete this booking?')" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="d-md-none">
            @foreach($bookings as $b)
            <div class="card mb-3 shadow-sm border">
                <div class="card-body">
                    <div class="d-flex mb-2 align-items-center">
                        <img src="{{ $b->tour->image ? asset('storage/'.$b->tour->image) : asset('images/no-image.png') }}"
                             alt="{{ $b->tour->name }}" width="60" class="rounded me-2">
                        <div>
                            <h6 class="fw-bold mb-0">{{ $b->tour->name }}</h6>
                            <small>{{ $b->customer->first_name }} {{ $b->customer->last_name }}</small>
                        </div>
                    </div>

                    <p class="mb-1"><strong>Pick Date:</strong> {{ \Carbon\Carbon::parse($b->pick_date)->format('d-m-Y') }}</p>
                    <p class="mb-1">
                        <strong>Status:</strong>
                        <span class="badge {{ $b->status === 'approved' ? 'bg-success' : ($b->status === 'cancelled' ? 'bg-danger' : 'bg-warning') }}">
                            {{ ucfirst($b->status) }}
                        </span>
                    </p>
                    <p class="mb-1"><strong>Total (AED):</strong> {{ number_format($b->total_price, 2) }}</p>

                    <div class="d-flex gap-1 mt-2 flex-wrap">
                        <a href="{{ route('tour-bookings.show', $b->id) }}" class="btn btn-sm btn-outline-secondary flex-grow-1">
                            <i class="bi bi-eye"></i> View
                        </a>
                        <a href="{{ route('tour-bookings.edit', $b->id) }}" class="btn btn-sm btn-outline-primary flex-grow-1">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('tour-bookings.destroy', $b->id) }}" method="POST" class="flex-grow-1">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Delete this booking?')" class="btn btn-sm btn-outline-danger w-100">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach

            @if($bookings->isEmpty())
            <p class="text-center text-muted py-4">No bookings found</p>
            @endif
        </div>

        {{ $bookings->links() }}
    </div>
</div>

@endsection

@push('scripts')
<script>
setTimeout(function () {
    const alert = document.getElementById('successAlert');
    if (alert) {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    }
}, 3000); // 3 seconds
</script>
@endpush
