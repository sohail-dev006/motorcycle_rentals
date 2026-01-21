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

<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table align-middle mb-0" id="customersTable">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    {{-- <th>City</th> --}}
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

                    <td class="fw-semibold customer-name">
                        {{ $customer->first_name }} {{ $customer->last_name }}
                    </td>

                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->mobile }}</td>
                    {{-- <td class="customer-city">{{ $customer->city }}</td> --}}
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
                            <button class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Delete this customer?')">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        No customers found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $customers->links() }}
</div>

@endsection

@push('scripts')
<script>
    // Frontend Search Filter
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#customersTable tbody tr');

        rows.forEach(row => {
            const name = row.querySelector('.customer-name').textContent.toLowerCase();
            const city = row.querySelector('.customer-city').textContent.toLowerCase();
            const country = row.querySelector('.customer-country').textContent.toLowerCase();

            if(name.includes(filter) || city.includes(filter) || country.includes(filter)) {
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

<style>
.object-fit-cover {
    object-fit: cover;
}
</style>
