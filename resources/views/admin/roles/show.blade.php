@extends('layouts.admin')

@section('title','Role Permissions')
@section('page-title','Manage Permissions')

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-body">

        <h5 class="mb-3">
            Role: <span class="text-primary">{{ $role->name }}</span>
        </h5>

        <form method="POST" action="{{ route('admin.roles.permissions.update', $role) }}">
            @csrf
            @method('PUT')

            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="table-light">
                        <tr>
                            <th class="text-start">Module</th>
                            <th>Create</th>
                            <th>List</th>
                            <th>Detail</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $modules = $permissions->groupBy('module');
                            $actions = ['create', 'list', 'detail', 'edit', 'delete'];


                            $actionMap = [
                                'add' => 'create',
                                'edit' => 'edit',
                                'delete' => 'delete',
                                'list' => 'list',
                                'view' => 'detail',
                            ];
                        @endphp

                        @foreach($modules as $module => $modulePermissions)
                            <tr>
                                <td class="text-start fw-bold">{{ $module }}</td>

                                @foreach($actions as $action)
                                    @php
                                        
                                        $perm = $modulePermissions->first(function($p) use($action, $actionMap) {
                                            foreach ($actionMap as $key => $mapped) {
                                                if ($mapped == $action && str_contains($p->name, $key)) {
                                                    return true;
                                                }
                                            }
                                            return false;
                                        });
                                    @endphp
                                    <td>
                                        @if($perm)
                                            <input type="checkbox"
                                                   class="perm-checkbox"
                                                   name="permissions[]"
                                                   value="{{ $perm->name }}"
                                                   {{ $role->hasPermissionTo($perm->name) ? 'checked' : '' }}
                                                   {{ auth()->user()->hasRole('Super Admin') ? '' : 'disabled' }}>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- @if(auth()->user()->hasRole('Super Admin')) --}}
                <button class="btn btn-success mt-3">
                    <i class="fa fa-save me-1"></i> Update Permissions
                </button>
            {{-- @endif --}}
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const selectAll = document.createElement('input');
    selectAll.type = 'checkbox';
    selectAll.id = 'select-all-global';
    const header = document.querySelector('thead tr th.text-start');
    header.prepend(selectAll);
    selectAll.addEventListener('change', function() {
        document.querySelectorAll('.perm-checkbox').forEach(cb => {
            if (!cb.disabled) cb.checked = this.checked;
        });
    });
</script>
@endpush
