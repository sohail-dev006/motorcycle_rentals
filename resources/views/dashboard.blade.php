@extends('layouts.admin')

@section('title','Dashboard')
@section('page-title','Admin Dashboard')

@section('content')

{{-- ===== STATS CARDS ===== --}}
<div class="row g-4 mb-4">

    @php
        $stats = [
            ['title'=>'Total Bookings','value'=>$totalTourBookings,'icon'=>'fa-calendar-check','color'=>'primary'],
            ['title'=>'Approved','value'=>$approvedBookings,'icon'=>'fa-check-circle','color'=>'success'],
            ['title'=>'Pending','value'=>$pendingBookings,'icon'=>'fa-clock','color'=>'warning'],
            ['title'=>'Cancelled','value'=>$cancelledBookings,'icon'=>'fa-times-circle','color'=>'danger'],
            ['title'=>'Due Today','value'=>$dueBookings,'icon'=>'fa-bell','color'=>'info'],
            ['title'=>'Customers','value'=>$customers,'icon'=>'fa-users','color'=>'secondary'],
        ];
    @endphp

    @foreach($stats as $stat)
    <div class="col-12 col-sm-6 col-xl-2">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <div class="icon-box bg-{{ $stat['color'] }}">
                    <i class="fa {{ $stat['icon'] }}"></i>
                </div>
                <div class="ms-3">
                    <small class="text-muted">{{ $stat['title'] }}</small>
                    <h5 class="fw-bold mb-0">{{ $stat['value'] }}</h5>
                </div>
            </div>
        </div>
    </div>
    @endforeach

</div>

{{-- ===== MOTORCYCLES ===== --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <small class="text-muted">Total Motorcycles</small>
                <h4 class="fw-bold">{{ $totalMotorcycles }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <small class="text-muted">Available</small>
                <h4 class="fw-bold text-success">{{ $availableMotorcycles }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <small class="text-muted">Booked</small>
                <h4 class="fw-bold text-danger">{{ $bookedMotorcycles }}</h4>
            </div>
        </div>
    </div>
</div>

{{-- ===== PICK / DROP ===== --}}
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <small class="text-muted">Today Pickups</small>
                <h4 class="fw-bold">{{ $todayPickups }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <small class="text-muted">Today Drops</small>
                <h4 class="fw-bold">{{ $todayDrops }}</h4>
            </div>
        </div>
    </div>
</div>

{{-- ===== CHARTS ===== --}}
<div class="row g-4 mb-4">
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Booking Status</h6>
                <canvas id="bookingChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Bookings Bar</h6>
                <canvas id="bookingBarChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Booking Trend</h6>
                <canvas id="bookingLineChart"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- ===== RECENT BOOKINGS ===== --}}
<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-bold">
        Recent Bookings
    </div>

    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Customer</th>
                    <th>Tour</th>
                    <th>Motorcycle</th>
                    <th>Pick Date</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentBookings as $booking)
                <tr>
                    <td>{{ $booking->customer->first_name ?? '—' }}</td>
                    <td>{{ $booking->tour->name ?? '—' }}</td>
                    <td>{{ $booking->motorcycle->name ?? '—' }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->pick_date)->format('d M Y') }}</td>
                    <td>AED {{ number_format($booking->total_price ?? 0,2) }}</td>
                    <td>
                        <span class="badge bg-{{ 
                            $booking->status == 'approved' ? 'success' : 
                            ($booking->status == 'pending' ? 'warning' : 'danger') 
                        }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No data</td>
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
        labels: ['Approved', 'Pending', 'Cancelled'],
        datasets: [{
            data: [{{ $approvedBookings }}, {{ $pendingBookings }}, {{ $cancelledBookings }}],
            backgroundColor: ['#198754', '#ffc107', '#dc3545']
        }]
    }
    // options: {
    //     responsive: true,
    //     maintainAspectRatio: false // Canvas ke width/height ko strictly follow kare
    // }
});
new Chart(document.getElementById('bookingBarChart'), {
    type: 'bar', // Bar chart type
    data: {
        labels: ['Approved', 'Pending', 'Cancelled'],
        datasets: [{
            label: 'Bookings',
            data: [{{ $approvedBookings }}, {{ $pendingBookings }}, {{ $cancelledBookings }}],
            backgroundColor: ['#198754', '#ffc107', '#dc3545'],
            borderColor: ['#145c32', '#856404', '#842029'],
            borderWidth: 1
        }]
    },
    // options: {
    //     responsive: true,
    //     maintainAspectRatio: false,
    //     scales: {
    //         y: {
    //             beginAtZero: true,
    //             ticks: {
    //                 stepSize: 1 
    //             }
    //         }
    //     },
    //     plugins: {
    //         legend: {
    //             display: false 
    //         }
    //     }
    // }
});
new Chart(document.getElementById('bookingLineChart'), {
    type: 'line',
    data: {
        labels: ['Approved', 'Pending', 'Cancelled'], 
        datasets: [
            {
                label: 'Bookings',
                data: [{{ $approvedBookings }}, {{ $pendingBookings }}, {{ $cancelledBookings }}],
                fill: false, 
                borderColor: '#0d6efd', 
                backgroundColor: '#0d6efd',
                tension: 0.4, 
                pointBackgroundColor: ['#198754', '#ffc107', '#dc3545'], 
                pointRadius: 6
            }
        ]
    },
    // options: {
    //     responsive: true,
    //     maintainAspectRatio: false,
    //     scales: {
    //         y: {
    //             beginAtZero: true,
    //             ticks: {
    //                 stepSize: 1
    //             }
    //         }
    //     },
    //     plugins: {
    //         legend: {
    //             display: true
    //         },
    //         tooltip: {
    //             enabled: true
    //         }
    //     }
    // }
});
</script>
@endpush
<style>
.stat-card {
    transition: all .3s ease;
}
.stat-card:hover {
    transform: translateY(-5px);
}
.icon-box {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 18px;
}
</style>
