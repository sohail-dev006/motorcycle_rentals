@extends('layouts.admin')

@section('title','Customers')
@section('page-title','Customers')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Customers</h4>
    <a href="{{ route('customers.create') }}" class="btn btn-warning rounded-pill">
        <i class="fa fa-plus me-1"></i> Add Customer
    </a>
</div>

@if(session('success'))
<div class="alert alert-success" id="successAlert">
    {{ session('success') }}
</div>
@endif

{{-- Search Box --}}
<div class="mb-3">
    <input type="text" id="searchInput" class="form-control" placeholder="Search customers by name, city, or country...">
</div>

{{-- Desktop Table --}}
<div class="card shadow-sm border-0 d-none d-md-block">
    <div class="table-responsive">
        <table class="table align-middle mb-0" id="customersTable">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Country</th>
                    <th width="120">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>
                        @if($customer->image)
                            <img 
                                src="{{ asset('storage/'.$customer->image) }}" 
                                alt="Customer Image"
                                width="45"
                                height="45"
                                class="rounded-circle object-fit-cover"
                            >
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td class="fw-semibold customer-name">{{ $customer->first_name }} {{ $customer->last_name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->mobile }}</td>
                    <td class="customer-country">{{ $customer->country }}</td>
                    <td class="d-flex gap-1">
                        <div class="">
                            <a href="{{ route('customers.show',$customer) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fa fa-eye"></i>
                            </a>
                        </div>
                        <div class="">
                            <a href="{{ route('customers.edit',$customer) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fa fa-pen"></i>
                            </a>
                        </div>
                        <form method="POST" action="{{ route('customers.destroy',$customer) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this customer?')">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">No customers found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Mobile Cards --}}
<div class="d-md-none">
    @forelse($customers as $customer)
    <div class="card mb-3 shadow-sm border">
        <div class="card-body">
            <div class="d-flex align-items-center mb-2">
                @if($customer->image)
                <img src="{{ asset('storage/'.$customer->image) }}" alt="Customer" width="60" height="60" class="rounded-circle object-fit-cover me-2">
                @else
                <div class="rounded-circle bg-secondary text-white d-flex justify-content-center align-items-center" style="width:60px; height:60px;">—</div>
                @endif
                <div>
                    <h6 class="fw-bold mb-0">{{ $customer->first_name }} {{ $customer->last_name }}</h6>
                    <small>{{ $customer->email }}</small>
                </div>
            </div>

            <p class="mb-1"><strong>Mobile:</strong> {{ $customer->mobile }}</p>
            <p class="mb-1"><strong>Country:</strong> {{ $customer->country }}</p>

            <div class="d-flex gap-1 mt-2 flex-wrap">
                <a href="{{ route('customers.show',$customer) }}" class="btn btn-sm btn-outline-secondary flex-grow-1">View</a>
                <a href="{{ route('customers.edit',$customer) }}" class="btn btn-sm btn-outline-primary flex-grow-1">Edit</a>
                <form method="POST" action="{{ route('customers.destroy',$customer) }}" class="flex-grow-1">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger w-100" onclick="return confirm('Delete this customer?')">Delete</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <p class="text-center text-muted py-4">No customers found</p>
    @endforelse
</div>

{{-- Pagination --}}
<div class="mt-3 d-none d-md-block">
    {{-- {{ $customers->links() }} --}}
</div>

@endsection

@push('scripts')
<script>
    // Frontend Search Filter for both table and cards
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', function() {
        const filter = this.value.toLowerCase();

        // Table rows
        const rows = document.querySelectorAll('#customersTable tbody tr');
        rows.forEach(row => {
            const name = row.querySelector('.customer-name').textContent.toLowerCase();
            const country = row.querySelector('.customer-country').textContent.toLowerCase();
            if(name.includes(filter) || country.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        // Mobile cards
        const cards = document.querySelectorAll('.d-md-none .card');
        cards.forEach(card => {
            const name = card.querySelector('h6').textContent.toLowerCase();
            const country = card.querySelector('p strong + text, p:nth-child(2)').textContent.toLowerCase();
            if(name.includes(filter) || country.includes(filter)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // Auto-hide alert
    setTimeout(() => {
        const alert = document.getElementById('successAlert');
        if(alert) alert.remove();
    }, 3000);
</script>
@endpush

<style>
.object-fit-cover {
    object-fit: cover;
}
</style>
