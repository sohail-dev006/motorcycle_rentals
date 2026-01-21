<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('role-list'))) {
            abort(403, 'Unauthorized action.');
        }
        $roles = Role::with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('add-role'))) {
            abort(403, 'Unauthorized action.');
        }
        $permissions = Permission::all()->groupBy('module');
        return view('admin.roles.create', compact('permissions'));
    }


    public function show(Role $role)
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('role-list'))) {
            abort(403, 'Unauthorized action.');
        }
        $permissions = Permission::all();

        return view('admin.roles.show', compact('role', 'permissions'));
    }

    public function updatePermissions(Request $request, Role $role)
    {
        $role->syncPermissions($request->permissions ?? []);

        return redirect()
           ->route('admin.roles.index')
           ->with('success', 'Permissions updated successfully');
    }
    public function store(Request $request)
    {
        $role = Role::create(['name'=>$request->name]);
        $role->syncPermissions($request->permissions ?? []);
        return redirect()->route('admin.roles.index');
    }

    public function destroy(Role $role)
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('delete-role'))) {
            abort(403, 'Unauthorized action.');
        }
        $role->delete();
        return back();
    }
}


