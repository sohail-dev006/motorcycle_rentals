@extends('layouts.admin')

@section('title','Roles & Permission')
@section('page-title','Manage Roles')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h4 class="fw-bold">Roles & Permission</h4>
    <a href="{{ route('admin.roles.create') }}" class="btn btn-warning">
        <i class="fa fa-plus me-1"></i> Add New Role
    </a>
</div>

{{-- Desktop Table --}}
<div class="card shadow-sm border-0 d-none d-md-block">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Role Name</th>
                    <th>Created On</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="role-name">{{ $role->name }}</td>
                    <td>{{ $role->created_at->format('d-m-Y') }}</td>
                    <td class="d-flex gap-1">
                        <a href="{{ route('admin.roles.show', $role) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-eye"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.roles.destroy',$role) }}">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete role?')">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Mobile Cards --}}
<div class="d-md-none">
    @forelse($roles as $role)
    <div class="card mb-3 shadow-sm border">
        <div class="card-body">
            <h6 class="fw-bold">{{ $role->name }}</h6>
            <p class="mb-2"><strong>Created On:</strong> {{ $role->created_at->format('d-m-Y') }}</p>
            <div class="d-flex gap-1 flex-wrap">
                <a href="{{ route('admin.roles.show', $role) }}" class="btn btn-sm btn-outline-primary flex-grow-1">View</a>
                <form method="POST" action="{{ route('admin.roles.destroy',$role) }}" class="flex-grow-1">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger w-100" onclick="return confirm('Delete role?')">Delete</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <p class="text-center text-muted py-4">No roles found</p>
    @endforelse
</div>

@endsection

