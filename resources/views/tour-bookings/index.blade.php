@extends('layouts.admin')

@section('title','Tour Bookings')
@section('page-title','Tour Bookings')

@section('content')

@if(session('success'))
<div class="alert alert-success" id="successAlert">{{ session('success') }}</div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-body">

        <a href="{{ route('tour-bookings.create') }}" class="btn btn-warning mb-3">
            + Add Booking
        </a>

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
                    {{-- Tour Image --}}
                    <td>
                        <img src="{{ $b->tour->image ? asset('storage/'.$b->tour->image) : asset('images/no-image.png') }}"
                             alt="{{ $b->tour->name }}"
                             width="60"
                             class="rounded">
                    </td>

                    {{-- Customer Name --}}
                    <td>{{ $b->customer->first_name }} {{ $b->customer->last_name }}</td>

                    {{-- Tour Name --}}
                    <td>{{ $b->tour->name }}</td>

                    {{-- Pick Date --}}
                    <td>{{ \Carbon\Carbon::parse($b->pick_date)->format('d-m-Y') }}</td>

                    {{-- Status --}}
                    <td>
                        <span class="badge {{ $b->status === 'approved' ? 'bg-success' : ($b->status === 'cancelled' ? 'bg-danger' : 'bg-warning') }}">
                            {{ ucfirst($b->status) }}
                        </span>
                    </td>

                    {{-- Total Price --}}
                    <td>{{ number_format($b->total_price, 2) }}</td>

                    {{-- Actions --}}
                    <td>
                        <a href="{{ route('tour-bookings.show', $b->id) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('tour-bookings.edit', $b->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('tour-bookings.destroy', $b->id) }}" method="POST" class="d-inline">
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

        {{ $bookings->links() }}
    </div>
</div>
@endsection
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