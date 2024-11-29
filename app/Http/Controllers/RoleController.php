<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('role.index', compact('roles'));
    }



    // Show form for creating a new role
    public function create()
    {
        $permissions = Permission::all();
        return view('role.create', compact('permissions'));
    }

    // Store a newly created role
    public function store(Request $request)
    {

        // return $request;

        $validated = $request->validate([
            'name' => 'required|unique:roles',
            'permissions' => 'array',
        ]);

        $role = Role::create(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions'] ?? []);

        return redirect()->route('role.index')->with('success', 'Role created successfully.');
    }

    // Show form for editing a role
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('role.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    // Update the specified role
    public function update(Request $request, Role $role)
    {



        $validated = $request->validate(
            rules: [
                'name' => 'required|unique:roles,name,' . $role->id,
                'permissions' => 'array|min:1',
            ],
            messages: [
                'permissions.min' => 'You must assign at least one permission to the role.',
            ]
        );

        $role->update(['name' => $validated['name']]);
        
        // Retrieve permissions by IDs and sync by names
        $permissions = Permission::whereIn('id', $validated['permissions'] ?? [])->get();
        $role->syncPermissions($permissions);
        

        return redirect()->route('role.index')->with('success', 'Role updated successfully.');
    }

    // Delete a role
    public function destroy(Role $role)
    {
        if ($role->name == 'super-admin') {
            return redirect()->back()->with('error', "Can't delte super-admin");
        }
        $role->delete();

        return redirect()->route('role.index')->with('success', 'Role deleted successfully.');
    }
}
