@extends('layouts.admin')

@section('title','Motorcycle Bookings')
@section('page-title','Motorcycle Bookings')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Motorcycle Bookings</h4>
    <a href="{{ route('bookings.create') }}" class="btn btn-warning rounded-pill">
        <i class="fa fa-plus me-1"></i> Add Booking
    </a>
</div>

@if(session('success'))
<div class="alert alert-success" id="successAlert">
    {{ session('success') }}
</div>
@endif

{{-- Search --}}
<div class="mb-3">
    <input type="text" id="searchInput" class="form-control" placeholder="Search by customer or motorcycle...">
</div>

<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-bordered align-middle mb-0" id="bookingsTable">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Motorcycle</th>
                    <th>Add-ons</th>
                    <th>Pick / Drop</th>
                    <th>Status</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->customer->first_name }} {{ $booking->customer->last_name }}</td>
                    <td>{{ $booking->motorcycle->name }}</td>
                    <td>
                        @if($booking->addons)
                            {{ implode(', ', $booking->addons) }}
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>{{ $booking->pick_date->format('d-m-Y') }} {{ $booking->pick_time }} <br> {{ $booking->drop_date->format('d-m-Y') }} {{ $booking->drop_time }}</td>
                    <td>{{ ucfirst($booking->status) }}</td>
                    <td class="d-flex gap-1">
                        <a href="{{ route('bookings.show',$booking) }}" class="btn btn-sm btn-outline-secondary"><i class="fa fa-eye"></i></a>
                        <a href="{{ route('bookings.edit',$booking) }}" class="btn btn-sm btn-outline-primary"><i class="fa fa-pen"></i></a>
                        <form method="POST" action="{{ route('bookings.destroy',$booking) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this booking?')">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">No bookings found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $bookings->links() }}
</div>

@endsection

@push('scripts')
<script>
const searchInput = document.getElementById('searchInput');
searchInput.addEventListener('input', function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#bookingsTable tbody tr');

    rows.forEach(row => {
        const customer = row.cells[1].textContent.toLowerCase();
        const motorcycle = row.cells[2].textContent.toLowerCase();

        if(customer.includes(filter) || motorcycle.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

    setTimeout(() => {
        const alert = document.getElementById('successAlert');
        if (alert) alert.remove();
    }, 3000);
</script>
@endpush
