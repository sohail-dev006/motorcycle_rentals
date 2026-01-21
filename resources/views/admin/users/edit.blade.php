@extends('layouts.admin')

@section('title','Edit User')
@section('page-title','Edit User')

@section('content')

    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')

        <div class="card shadow-sm border-0">
            <div class="card-body">

                <div class="row g-3">

                    <!-- Name -->
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input name="name"
                            class="form-control"
                            value="{{ old('name', $user->name) }}"
                            required>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input name="email"
                            type="email"
                            class="form-control"
                            value="{{ old('email', $user->email) }}"
                            required>
                    </div>

                    <!-- Password -->
                    <div class="col-md-6">
                        <label class="form-label">
                            Password <small class="text-muted">(leave blank to keep same)</small>
                        </label>
                        <input name="password"
                            type="password"
                            class="form-control">
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>


                    <!-- Role -->
                    <div class="col-md-6">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}"
                                    {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

            </div>

            <div class="card-footer text-end">
                <button class="btn btn-warning">
                    <i class="fa fa-save me-1"></i> Update User
                </button>
            </div>

        </div>
    </form>

@endsection
