@extends('layouts.admin')

@section('title','Users')
@section('page-title','Manage Users')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h4 class="fw-bold">Users</h4>

    @can('add-user')
    <a href="{{ route('admin.users.create') }}" class="btn btn-warning">
        <i class="fa fa-plus"></i> Add User
    </a>
    @endcan
</div>

{{-- Search Form --}}
<form method="GET" action="{{ route('admin.users') }}" class="mb-3">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search by name or email" value="{{ request('search') }}">
        <button class="btn btn-primary" type="submit">
            <i class="fa fa-search"></i> Search
        </button>
    </div>
</form>

{{-- Desktop Table --}}
<div class="card shadow-sm border-0 d-none d-md-block">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="{{ $user->status === 'active' ? 'bg-success text-white px-2 py-1 rounded' : 'bg-danger text-white px-2 py-1 rounded' }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </td>
                    <td>{{ $user->roles->pluck('name')->first() ?? '-' }}</td>
                    <td class="d-flex gap-2">
                        @can('edit-user')
                        <a href="{{ route('admin.users.edit',$user) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-pen"></i>
                        </a>
                        @endcan

                        @can('delete-user')
                        <form method="POST" action="{{ route('admin.users.destroy',$user) }}">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete user?')">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No users found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $users->withQueryString()->links() }}
    </div>
</div>

{{-- Mobile Cards --}}
<div class="d-md-none">
    @forelse($users as $user)
    <div class="card mb-3 shadow-sm border">
        <div class="card-body">
            <h6 class="fw-bold">{{ $user->name }}</h6>
            <p class="mb-1"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="mb-1">
                <strong>Status:</strong>
                <span class="{{ $user->status === 'active' ? 'bg-success text-white px-2 py-1 rounded' : 'bg-danger text-white px-2 py-1 rounded' }}">
                    {{ ucfirst($user->status) }}
                </span>
            </p>
            <p class="mb-2"><strong>Role:</strong> {{ $user->roles->pluck('name')->first() ?? '-' }}</p>

            <div class="d-flex gap-1 flex-wrap">
                @can('edit-user')
                <a href="{{ route('admin.users.edit',$user) }}" class="btn btn-sm btn-outline-primary flex-grow-1">Edit</a>
                @endcan

                @can('delete-user')
                <form method="POST" action="{{ route('admin.users.destroy',$user) }}" class="flex-grow-1">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger w-100" onclick="return confirm('Delete user?')">Delete</button>
                </form>
                @endcan
            </div>
        </div>
    </div>
    @empty
    <p class="text-center text-muted py-4">No users found.</p>
    @endforelse
</div>

@endsection
