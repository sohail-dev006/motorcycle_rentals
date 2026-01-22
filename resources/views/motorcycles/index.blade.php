@extends('layouts.admin')

@section('title', 'Motorcycle List')
@section('page-title', 'Motorcycle List')

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
                <h4 class="mb-1">Motorcycle List</h4>
                <small class="text-muted">Manage your Motorcycles</small>
            </div>

            <a href="{{ route('motorcycles.create') }}" class="btn btn-warning text-white">
                <i class="bi bi-plus-circle"></i> Add New Motorcycle
            </a>
        </div>

        <div class="mb-2">
            {{-- <form id="importForm"
      action="{{ route('motorcycles.import') }}"
      method="POST"
      enctype="multipart/form-data">
    @csrf

    <input type="file"
           name="file"
           id="csvFileInput"
           accept=".csv"
           style="display:none">

    <button type="button"
            class="btn btn-warning text-white"
            onclick="openFilePicker()">
        <i class="bi bi-upload"></i> Import CSV
    </button>
</form> --}}


            <form action="{{ route('motorcycles.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="d-flex gap-2 align-items-center">
                    <div class="">
                        <input type="file" name="file" class="form-control" accept=".csv" required>
                    </div>
                    <button type="submit" class="btn btn-warning text-white">
                        <i class="bi bi-plus-circle"></i> Import CSV
                    </button>
                </div>
            </form>
        </div>

        {{-- SEARCH FORM --}}
        <form method="GET" class="mb-3 d-flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by name or code">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>


        {{-- Table for md and up --}}
        <div class="table-responsive d-none d-md-block">
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
                                <img src="{{ $m->image ? asset('storage/' . $m->image) : asset('images/no-image.png') }}"
                                     width="50" class="rounded">
                            </td>
                            <td>{{ $m->name }}</td>
                            <td>{{ $m->code }}</td>
                            <td>{{ $m->sort_order }}</td>
                            <td>
                                <span class="badge bg-success">{{ ucfirst($m->status) }}</span>
                            </td>
                            <td>
                                {{-- @php
                                    logger('Motorcycle ID: ' . $m->id . ', base: ' . $m->base_price . ', extra: ' . $m->extra_price . ', saved price: ' . $m->price);
                                @endphp --}}
                                AED {{ number_format($m->price, 2) }}
                            </td>

                            <td class="text-center">
                                <a href="{{ route('motorcycles.show', $m->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('motorcycles.edit', $m->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('motorcycles.destroy', $m->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this motorcycle?')" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No motorcycles found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Card view for small screens --}}
        <div class="d-block d-md-none">
            @forelse($motorcycles as $m)
                <div class="card mb-3 shadow-sm">
                    <div class="row g-0">
                        <div class="col-4">
                            <img src="{{ $m->image ? asset('storage/' . $m->image) : asset('images/no-image.png') }}"
                                 class="img-fluid rounded-start" alt="{{ $m->name }}">
                        </div>
                        <div class="col-8">
                            <div class="card-body p-2">
                                <h5 class="card-title mb-1">{{ $m->name }}</h5>
                                <p class="mb-1"><strong>Code:</strong> {{ $m->code }}</p>
                                <p class="mb-1"><strong>Sort Order:</strong> {{ $m->sort_order }}</p>
                                <p class="mb-1"><strong>Status:</strong> <span class="badge bg-success">{{ ucfirst($m->status) }}</span></p>
                                <p class="mb-1"><strong>Price:</strong> AED {{ number_format($m->price, 2) }}</p>

                                <div class="d-flex gap-1 mt-2">
                                    <a href="{{ route('motorcycles.show', $m->id) }}" class="btn btn-sm btn-outline-secondary flex-fill">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <a href="{{ route('motorcycles.edit', $m->id) }}" class="btn btn-sm btn-outline-primary flex-fill">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('motorcycles.destroy', $m->id) }}" method="POST" class="flex-fill">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Delete this motorcycle?')" class="btn btn-sm btn-outline-danger w-100">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">No motorcycles found</p>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{-- {{ $motorcycles->links() }} --}}
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
}, 3000);

function openFilePicker() {
    document.getElementById('csvFileInput').click();
}

document.getElementById('csvFileInput').addEventListener('change', function () {
    if (this.files.length > 0) {
        document.getElementById('importForm').submit();
    }
});



</script>
