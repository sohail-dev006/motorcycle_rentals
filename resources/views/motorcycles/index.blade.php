@extends('layouts.admin')

@section('title', 'Motorcycle List')
@section('page-title', 'Motorcycle List')

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Motorcycle List</h4>
                <small class="text-muted">Manage your Motorcycles</small>
            </div>

            {{-- <a href="{{ route('admin.motorcycles.create') }}" class="btn btn-warning text-white">
                <i class="bi bi-plus-circle"></i> Add New Motorcycle
            </a> --}}
        </div>

        {{-- Top Actions --}}
        <div class="d-flex justify-content-between mb-3">
            {{-- <a href="{{ route('admin.motorcycles.import') }}" class="btn btn-warning text-white">
                Import CSV File
            </a> --}}

            <button class="btn btn-outline-secondary">
                <i class="bi bi-funnel"></i>
            </button>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th><input type="checkbox"></th>
                        <th>Image</th>
                        <th>Motorcycle</th>
                        <th>Code</th>
                        <th>Sort Order</th>
                        <th>Status</th>
                        <th>Price</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($motorcycles as $m)
                        <tr>
                            <td><input type="checkbox"></td>

                            <td>
                                <img src="{{ $m->image
                                    ? asset('storage/' . $m->image)
                                    : asset('images/no-image.png') }}"
                                    width="50"
                                    class="rounded">
                            </td>


                            <td>{{ $m->name }}</td>

                            <td>{{ $m->code }}</td>

                            <td>{{ $m->sort_order }}</td>

                            <td>
                                <span class="badge bg-success">
                                    {{ ucfirst($m->status) }}
                                </span>
                            </td>

                            <td>AED {{ number_format($m->price, 2) }}</td>

                            <td class="text-center">
                                {{-- <a href="{{ route('admin.motorcycles.show', $m->id) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('admin.motorcycles.edit', $m->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a> --}}

                                {{-- <form action="{{ route('admin.motorcycles.destroy', $m->id) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this motorcycle?')"
                                            class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form> --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                No motorcycles found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $motorcycles->links() }}
        </div>

    </div>
</div>
@endsection
