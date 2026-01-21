<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserPermissionController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('user-list'))) {
            abort(403, 'Unauthorized action.');
        }
        $search = $request->search;

        $users = User::with('roles')
        ->when($search, function ($q) use ($search) {
            $q->where('name', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%");
        })
        ->latest()
        ->paginate(10);
        // $users = User::with('roles')->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('add-user'))) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.users.create', [
            'roles' => Role::all(),
            'permissions' => Permission::all()->groupBy('module')
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6',
            'role'=>'required',
            'status'=>'required|in:active,inactive',
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'status'=>$request->status,
        ]);

        $user->assignRole($request->role);
        $user->syncPermissions($request->permissions ?? []);

        return redirect()->route('admin.users')->with('success','User created');
    }

    public function edit(User $user)
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('edit-user'))) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => Role::all(),
            'permissions' => Permission::all()->groupBy(function ($p) {
                return explode('-', $p->name)[0];
            }),
            'userPermissions' => $user->getPermissionNames()->toArray()
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'=>'required',
            'email'=>"required|email|unique:users,email,$user->id",
            'role'=>'required',
            'status'=>'required|in:active,inactive',
        ]);

        $user->update(array_merge(
        $request->only('name','email','status'), 
        $request->filled('password') ? ['password' => bcrypt($request->password)] : []
    ));
        $user->update($request->only('name','email',));

        if ($request->password) {
            $user->update(['password'=>bcrypt($request->password)]);
        }

        $user->syncRoles([$request->role]);
        $user->syncPermissions($request->permissions ?? []);

        return redirect()->route('admin.users')->with('success','User updated');
    }

    public function destroy(User $user)
    {
        $user = auth()->user();

        if (!($user->hasRole('Super Admin') || $user->can('delete-user'))) {
            abort(403, 'Unauthorized action.');
        }
        $user->delete();
        return back()->with('success','User deleted');
    }
}


