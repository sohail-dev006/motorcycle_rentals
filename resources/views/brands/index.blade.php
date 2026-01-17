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

        {{-- Search --}}
        <form method="GET" class="mb-3 d-flex gap-2">
            <input type="text"
                   name="search"
                   value="{{ $search ?? '' }}"
                   class="form-control"
                   placeholder="Search Brand...">
            <button class="btn btn-outline-secondary">
                <i class="bi bi-search"></i>
            </button>
        </form>

        {{-- TABLE (md and up) --}}
        <div class="table-responsive d-none d-md-block">
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
                                <a href="{{ route('brands.edit', $brand->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('brands.destroy', $brand->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this brand?')"
                                            class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">
                                No brands found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- CARD VIEW (sm and below) --}}
        <div class="d-block d-md-none">
            @forelse($brands as $brand)
                <div class="card mb-2 shadow-sm">
                    <div class="card-body p-3">
                        <h5 class="mb-2">{{ $brand->name }}</h5>

                        <div class="d-flex gap-2">
                            <a href="{{ route('brands.edit', $brand->id) }}"
                               class="btn btn-sm btn-outline-primary flex-fill">
                                <i class="bi bi-pencil"></i> Edit
                            </a>

                            <form action="{{ route('brands.destroy', $brand->id) }}"
                                  method="POST"
                                  class="flex-fill">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete this brand?')"
                                        class="btn btn-sm btn-outline-danger w-100">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">No brands found</p>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $brands->links() }}
        </div>

    </div>
</div>

@push('scripts')
<script>
    setTimeout(() => {
        const alert = document.getElementById('successAlert');
        if (alert) alert.remove();
    }, 3000);
</script>
@endpush

@endsection
