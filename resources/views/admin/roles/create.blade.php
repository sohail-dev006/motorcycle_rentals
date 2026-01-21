@extends('layouts.admin')

@section('title','Create Role')
@section('page-title','Add New Role')

@section('content')

<form action="{{ route('admin.roles.store') }}" method="POST">
@csrf
<div class="card shadow-sm border-0">
    <div class="card-body">

        <div class="mb-3">
            <label class="form-label fw-semibold">Role Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter role name" required>
        </div>

        <hr>
        <h5 class="fw-bold mb-3">Assign Permissions</h5>

        <div class="mb-2">
            <label>
                <input type="checkbox" id="checkAll"> <strong>Select All</strong>
            </label>
        </div>

        @foreach($permissions as $module => $perms)
            <div class="border rounded p-3 mb-3">
                <strong class="d-block mb-2">{{ $module }}</strong>
                <div class="row">
                    @foreach($perms as $perm)
                        <div class="col-md-3">
                            <label>
                                <input type="checkbox" name="permissions[]" 
                                       value="{{ $perm->name }}" class="permission-checkbox">
                                {{ $perm->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

    </div>

    <div class="card-footer text-end">
        <button class="btn btn-warning">
            <i class="fa fa-save me-1"></i> Create Role
        </button>
    </div>
</div>
</form>

<script>
document.getElementById('checkAll').addEventListener('change', function () {
    document.querySelectorAll('.permission-checkbox')
        .forEach(cb => cb.checked = this.checked);
});
</script>

@endsection
