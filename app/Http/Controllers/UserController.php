<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasPermissionTo('show user')) {
            $users = User::all();
            $roles = Role::all();
            return view('users.index', ['users' => $users, 'roles' => $roles]);
        }

        return "not permisttion to show  users";

    }
    public function assignRole(Request $request, User $user)
    {
        // Validate the roles input
        $validatedData = $request->validate([
            'roles' => 'required|array|min:1',
            'roles.*' => 'string|exists:roles,name',
        ]);

        // Prevent assigning the admin role if the user is not already an admin
        if (!auth()->user()->hasRole('admin') && in_array('admin', $validatedData['roles'])) {
            return redirect()->back()->with('error', 'You cannot assign the admin role to this user.');
        }

        // Assign the roles to the user
        $user->syncRoles($validatedData['roles']); // Replaces all existing roles with the new ones
        return redirect()->back()->with('success', 'Roles assigned successfully.');
    }

    public function updateRole(Request $request, User $user)
    {
        // Validate the roles input
        $validatedData = $request->validate([
            'roles' => 'required|array|min:1',
            'roles.*' => 'string|exists:roles,name',
        ]);
        // Prevent assigning the admin role if the user is not already an admin . Admin can change there roles 
        if (!auth()->user()->hasRole('admin') && $user->hasRole('admin')) {
            return redirect()->back()->with('error', 'You cannot Edit the admin role only admin can edit the role of admin .');
        }
        $requestRoles = $validatedData;

        // $removeRoles = array_diff($existingRoles, $requestRoles);
        // $user->removeRole($removeRoles);

        $user->syncRoles($requestRoles);

        return redirect()->back()->with("success", 'Roles Updated!');
    }




}