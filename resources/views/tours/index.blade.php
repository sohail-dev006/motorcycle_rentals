@extends('layouts.admin')

@section('title', 'Tour List')
@section('page-title', 'Manage your Tours')

@section('content')
@if(session('success'))
    <div class="alert alert-success fade show" id="successAlert">
        {{ session('success') }}
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <h4 class="mb-1">Tour List</h4>
                <small class="text-muted">Manage your Tours</small>
            </div>

            <a href="{{ route('tours.create') }}" class="btn btn-warning text-white">
                <i class="bi bi-plus-circle"></i> Add New Tour
            </a>
        </div>
        <div class="mb-2">
            <a href="" class="btn btn-warning text-white">
                <i class="bi bi-plus-circle"></i> Import CSV File
            </a>
        </div>

        {{-- Search --}}
        <form method="GET" class="mb-3 d-flex gap-2">
            <input type="text"
                   name="search"
                   value="{{ $search ?? '' }}"
                   class="form-control"
                   placeholder="Search Tours...">
            <button class="btn btn-outline-secondary">
                <i class="bi bi-search"></i>
            </button>
        </form>

        {{-- TABLE (md and up) --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th><input type="checkbox"></th>
                        <th>Image</th>
                        <th>Tour Name</th>
                        <th>Status</th>
                        <th>Group Price</th>
                        <th>Private Price</th>
                        <th>Passenger Price</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tours as $tour)
                        <tr>
                            <td><input type="checkbox"></td>

                            <td>
                                <img src="{{ $tour->image
                                    ? asset('storage/'.$tour->image)
                                    : asset('images/no-image.png') }}"
                                    width="50"
                                    class="rounded">
                            </td>

                            <td>{{ $tour->name }}</td>

                            <td>
                                <span class="badge {{ $tour->status === 'featured' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($tour->status) }}
                                </span>
                            </td>

                            <td>AED {{ number_format($tour->group_price, 2) }}</td>
                            <td>AED {{ number_format($tour->private_price, 2) }}</td>
                            <td>AED {{ number_format($tour->passenger_price, 2) }}</td>

                            <td class="text-center">
                                <a href="{{ route('tours.show', $tour->id) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('tours.edit', $tour->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('tours.destroy', $tour->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this tour?')"
                                            class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                No tours found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- CARD VIEW (sm and below) --}}
        <div class="d-block d-md-none">
            @forelse($tours as $tour)
                <div class="card mb-2 shadow-sm">
                    <div class="card-body p-3">

                        <div class="d-flex gap-3 mb-2">
                            <img src="{{ $tour->image
                                ? asset('storage/'.$tour->image)
                                : asset('images/no-image.png') }}"
                                width="70"
                                class="rounded">

                            <div class="mt-1">
                                <h6 class="mb-1">{{ $tour->name }}</h6>
                                <span class="badge {{ $tour->status === 'featured' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($tour->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="small text-muted mb-2">
                            <div>Group: AED {{ number_format($tour->group_price, 2) }}</div>
                            <div>Private: AED {{ number_format($tour->private_price, 2) }}</div>
                            <div>Passenger: AED {{ number_format($tour->passenger_price, 2) }}</div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('tours.show', $tour->id) }}"
                               class="btn btn-sm btn-outline-secondary flex-fill">
                                <i class="bi bi-eye"></i> View
                            </a>

                            <a href="{{ route('tours.edit', $tour->id) }}"
                               class="btn btn-sm btn-outline-primary flex-fill">
                                <i class="bi bi-pencil"></i> Edit
                            </a>

                            <form action="{{ route('tours.destroy', $tour->id) }}"
                                  method="POST"
                                  class="flex-fill">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete this tour?')"
                                        class="btn btn-sm btn-outline-danger w-100">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            @empty
                <p class="text-center text-muted">No tours found</p>
            @endforelse
        </div>

        {{-- Pagination --}}
       
        <div class="mt-3">
            {{ $tours->links() }}
        </div>

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
