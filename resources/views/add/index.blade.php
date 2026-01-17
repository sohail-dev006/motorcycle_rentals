@extends('layouts.admin')

@section('title', 'New Add On')
@section('page-title', 'Add On list')

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
                <h4 class="mb-1">Add On's list</h4>
                <small class="text-muted">Manage your Add on</small>
            </div>

            <a href="{{ route('add.create') }}" class="btn btn-warning text-white">
                <i class="bi bi-plus-circle"></i> Create New Add On
            </a>
        </div>

        <form method="GET" class="mb-3 d-flex gap-2">
            <input type="text"
                name="search"
                value="{{ $search ?? '' }}"
                class="form-control"
                placeholder="Search Add On...">

            <button class="btn btn-outline-secondary">
                <i class="bi bi-search"></i>
            </button>
        </form>



        {{-- Table --}}
        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>Sub Product</th>
                        <th>Price</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($addons as $add)
                        <tr>
                            <td>
                                <img src="{{ $add->image
                                    ? asset('storage/'.$add->image)
                                    : asset('images/no-image.png') }}"
                                    width="50" class="rounded">
                            </td>


                            <td>{{ $add->name }}</td>

                            <td>AED {{ number_format($add->price, 2) }}</td>

                            <td class="text-center">
                                <a href="{{ route('add.show', $add->id) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('add.edit', $add->id) }}"
                                class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('add.destroy', $add->id) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this Add On?')"
                                            class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                No Add On found
                            </td>
                        </tr>
                    @endforelse
                    </tbody>

        </div>

        {{-- Pagination --}}
        {{-- <div class="mt-3">
            {{ $motorcycles->links() }}
        </div> --}}

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