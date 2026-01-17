@extends('layouts.admin')

@section('title', 'Manage Brands')
@section('page-title', 'Brands')

@section('content')
@if(session('success'))
    <div class="alert alert-success fade show" id="successAlert">
        {{ session('success') }}
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Brands</h4>
                <small class="text-muted">Manage your brands</small>
            </div>

            <a href="{{ route('brands.create') }}" class="btn btn-warning text-white">
                <i class="bi bi-plus-circle"></i> Add New Brand
            </a>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($brands as $brand)
                        <tr>
                            <td>{{ $brand->name }}</td>
                            <td class="text-center">
                                <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this brand?')" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">No brands found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $brands->links() }}
        </div>
    </div>
</div>

<script>
setTimeout(() => {
    const alert = document.getElementById('successAlert');
    if(alert) alert.remove();
}, 3000);
</script>
@endsection
