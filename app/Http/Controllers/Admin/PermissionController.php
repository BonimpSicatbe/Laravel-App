<?php

namespace App\Http\Controllers\Admin;

//use App\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all();

        return view('admin.permissions.index', compact(
            'permissions'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.permissions.create', compact(
            'roles',
            'permissions',
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

        Permission::create([
            'name' => $request['name'],
        ]);

        return redirect()->back()->with('success', 'Permission created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.permissions.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // ====================
    // CUSTOM ROUTES
    // ====================
        public function assign_role_permission()
    {
        return view('admin.permissions.assign_role_permission');
    }
}
