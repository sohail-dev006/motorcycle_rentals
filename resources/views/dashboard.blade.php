@extends('layouts.admin')

@section('title','Dashboard')
@section('page-title','Admin Dashboard')

@section('content')

{{-- TOP STATS --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm p-3">
            <small>Total Tour Bookings</small>
            <h3 class="fw-bold">{{ $totalTourBookings }}</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm p-3">
            <small>Approved Bookings</small>
            <h3 class="fw-bold text-success">{{ $approvedBookings }}</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm p-3">
            <small>Cancelled Bookings</small>
            <h3 class="fw-bold text-danger">{{ $cancelledBookings }}</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm p-3">
            <small>Due Bookings Today</small>
            <h3 class="fw-bold text-warning">{{ $dueBookings }}</h3>
        </div>
    </div>
</div>

{{-- SECOND ROW --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm p-3">
            <small>Customers</small>
            <h3 class="fw-bold">{{ $customers }}</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm p-3">
            <small>Available Motorcycles</small>
            <h3 class="fw-bold text-success">{{ $availableMotorcycles }}</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm p-3">
            <small>Booked Motorcycles</small>
            <h3 class="fw-bold text-danger">{{ $bookedMotorcycles }}</h3>
        </div>
    </div>
</div>

{{-- TODAY PICK / DROP --}}
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm p-3">
            <small>Today Pickups</small>
            <h3 class="fw-bold">{{ $todayPickups }}</h3>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm p-3">
            <small>Today Drops</small>
            <h3 class="fw-bold">{{ $todayDrops }}</h3>
        </div>
    </div>
</div>

{{-- CHART --}}
<div class="card shadow-sm p-3 mb-4">
    <h6 class="fw-bold mb-3">Approved vs Cancelled Bookings</h6>
    <canvas id="bookingChart" height="120"></canvas>
</div>

{{-- RECENT BOOKINGS --}}
<div class="card shadow-sm">
    <div class="card-header bg-white fw-bold">
        Recent Tour Bookings
    </div>

    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Customer</th>
                    <th>Tour</th>
                    <th>Motorcycle</th>
                    <th>Pick Date</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentBookings as $booking)
                <tr>
                    <td>{{ $booking->customer->first_name ?? '—' }} {{ $booking->customer->last_name ?? '' }}</td>
                    <td>{{ $booking->tour->name ?? '—' }}</td>
                    <td>{{ $booking->motorcycle->name ?? '—' }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->pick_date)->format('d M Y') }}</td>
                    <td>AED {{ number_format($booking->total_price ?? 0,2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No bookings found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('bookingChart'), {
    type: 'doughnut',
    data: {
        labels: ['Approved', 'Cancelled'],
        datasets: [{
            data: [{{ $approvedBookings }}, {{ $cancelledBookings }}],
            backgroundColor: ['#198754', '#dc3545']
        }]
    }
});
</script>
@endpush
