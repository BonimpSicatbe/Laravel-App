<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        $allUserWithTheirRoles = User::with('roles')->paginate(25);

        return view('admin.roles.index', compact(
            'roles',
            'allUserWithTheirRoles',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();

        return view('admin.roles.create', compact(
            'roles',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Role::create([
            'name' => $request['name'],
        ]);

        return redirect()->route('roles.index')->with('success', 'Role created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $permissions = $role->permissions;
        $assignedUsers = User::with(['roles', 'position'])
            ->whereHas('roles', function($query) use ($role) {
                $query->where('id', $role->id); // Assuming 'id' is the primary key for roles
            })->get();

        return view('admin.roles.show', compact(
            'role',
            'permissions',
            'assignedUsers',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role = Role::findById($role->id);
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully');
    }

    // =========================
    // CUSTOM
    // =========================
    public function remove_permission_from_role(Role $role, Permission $permission)
    {
        $role->revokePermissionTo($permission->name);

        return redirect()->route('roles.show', $role->id)->with('success', 'Permission removed successfully');
    }

    public function remove_user_from_role(Role $role, User $user)
    {
        $user->removeRole($role->name); // This assumes you have a many-to-many relationship set up

        return redirect()->route('roles.show', $role->id)->with('success', 'User removed successfully.');
    }

    public function store_user_roles(Request $request, Role $role)
    {
        $userIds = $request->input('users', []); // Get selected user IDs, default to empty array if none selected

        // Sync the users with the role
        $role->users()->sync($userIds); // Sync will add/remove users based on the provided IDs

        return redirect()->route('roles.show', $role->id)->with('success', 'Users assigned successfully.');
    }

    public function assign_user_roles(Request $request, Role $role)
    {
        $users = User::with('roles')->get();

        return view('admin.roles.assign', compact(
           'role',
            'users'
        ));
    }

    public function store_permission(Request $request, Role $role)
    {
        $permissions = $request->input('permissions', []); // Get selected permissions, default to empty array if none selected

        // Assign selected permissions to the role
        $role->syncPermissions($permissions);

        return redirect()->back()->with('success', 'Permissions assigned successfully.');
    }

    public function assign_permission(Role $role)
    {
        $permissions = Permission::all();
        $assignedPermissions = $role->permissions;

        return view('admin.roles.assign_permission', compact(
            'role',
        'permissions',
            'assignedPermissions',
        ));
    }
}
