@extends('layouts.admin')

@section('title','Motorcycle Bookings')
@section('page-title','Motorcycle Bookings')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Motorcycle Bookings</h4>
        <small class="text-muted">Manage your Bookings</small>
    </div>
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
    {{-- Desktop Table --}}
    <div class="table-responsive d-none d-md-block">
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

    {{-- Mobile Cards --}}
    <div class="d-md-none">
        @forelse($bookings as $booking)
        <div class="card mb-3 shadow-sm border">
            <div class="card-body">
                <h6 class="fw-bold mb-2">#{{ $booking->id }} - {{ $booking->customer->first_name }} {{ $booking->customer->last_name }}</h6>
                <p class="mb-1"><strong>Motorcycle:</strong> {{ $booking->motorcycle->name }}</p>
                <p class="mb-1"><strong>Add-ons:</strong> 
                    @if($booking->addons)
                        {{ implode(', ', $booking->addons) }}
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </p>
                <p class="mb-1"><strong>Pick / Drop:</strong> {{ $booking->pick_date->format('d-m-Y') }} {{ $booking->pick_time }} <br> {{ $booking->drop_date->format('d-m-Y') }} {{ $booking->drop_time }}</p>
                <p class="mb-1"><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>
                <div class="d-flex gap-1 mt-2 flex-wrap">
                    <a href="{{ route('bookings.show',$booking) }}" class="btn btn-sm btn-outline-secondary flex-grow-1"><i class="fa fa-eye"></i> View</a>
                    <a href="{{ route('bookings.edit',$booking) }}" class="btn btn-sm btn-outline-primary flex-grow-1"><i class="fa fa-pen"></i> Edit</a>
                    <form method="POST" action="{{ route('bookings.destroy',$booking) }}" class="flex-grow-1">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger w-100" onclick="return confirm('Delete this booking?')">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <p class="text-center text-muted py-4">No bookings found</p>
        @endforelse
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

    // Desktop rows
    const rows = document.querySelectorAll('#bookingsTable tbody tr');
    rows.forEach(row => {
        const customer = row.cells[1]?.textContent.toLowerCase() || '';
        const motorcycle = row.cells[2]?.textContent.toLowerCase() || '';
        row.style.display = (customer.includes(filter) || motorcycle.includes(filter)) ? '' : 'none';
    });

    // Mobile cards
    const cards = document.querySelectorAll('.d-md-none .card');
    cards.forEach(card => {
        const text = card.textContent.toLowerCase();
        card.style.display = text.includes(filter) ? '' : 'none';
    });
});

setTimeout(() => {
    const alert = document.getElementById('successAlert');
    if (alert) alert.remove();
}, 3000);
</script>
@endpush
