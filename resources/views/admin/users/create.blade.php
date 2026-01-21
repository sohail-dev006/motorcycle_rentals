@extends('layouts.admin')

@section('title','Add User')
@section('page-title','Add New User')

@section('content')

<form method="POST" action="{{ route('admin.users.store') }}">
@csrf

<div class="card shadow-sm border-0">
<div class="card-body">

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Name</label>
        <input name="name" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input name="email" type="email" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Password</label>
        <input name="password" type="password" class="form-control" required>
    </div>

    <!-- Status -->
    <div class="col-md-6">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
            <option value="active" >Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Role</label>
        <select name="role" class="form-select" required>
            @foreach($roles as $role)
                <option value="{{ $role->name }}">{{ $role->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<hr>

{{-- <h5 class="fw-bold mb-3">Permissions</h5>

@foreach($permissions as $module => $perms)
<div class="border rounded p-3 mb-3">
    <strong>{{ $module }}</strong>
    <div class="row mt-2">
        @foreach($perms as $perm)
        <div class="col-md-3">
            <label>
                <input type="checkbox" name="permissions[]" value="{{ $perm->name }}">
                {{ $perm->name }}
            </label>
        </div>
        @endforeach
    </div>
</div>
@endforeach --}}

</div>

<div class="card-footer text-end">
    <button class="btn btn-warning">
        <i class="fa fa-save me-1"></i> Save User
    </button>
</div>
</div>
</form>

@endsection
