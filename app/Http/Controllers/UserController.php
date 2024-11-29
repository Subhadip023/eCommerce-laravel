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



        if (!auth()->user()->hasRole('super-admin') && in_array('super-admin', $validatedData['roles'])) {
            return redirect()->back()->with('error', 'You cannot assign the super-admin role to this user. Only super adimin can do it ');
        }


        if (!auth()->user()->hasRole('super-admin') && in_array('admin', $validatedData['roles'])) {
            return redirect()->back()->with('error', 'You cannot assign the admin role to this user. Only super adimin can do it ');
        }

        // Assign the roles to the user
        $user->syncRoles($validatedData['roles']);
        return redirect()->back()->with('success', 'Roles assigned successfully.');
    }

    public function updateRole(Request $request, User $user)
    {
        // Validate the roles input
        
        
        // return $request['roles']===null ;
        $validatedData = $request->validate([
            'roles' => 'array',
            'roles.*' => 'string|exists:roles,name',
        ]);

        // return $validatedData==null;




        if (!auth()->user()->hasRole('super-admin') && in_array('super-admin', $validatedData['roles'])) {
            return redirect()->back()->with('error', 'You cannot assign the super-admin role to this user. Only super adimin can do it ');
        }


        // Prevent assigning the admin role if the user is not already an admin . Admin can change there roles 
        if (!auth()->user()->hasRole('admin') && in_array('admin', $validatedData['roles'])) {
            return redirect()->back()->with('error', 'You cannot Add the admin role only admin can Add the role of admin .');
        }

        if (auth()->user()->hasRole('admin') && $user->hasRole('admin') && auth()->user()->id !== $user->id) {
            return redirect()->back()->with('error', "Only {$user->name} can edit own roles. Only super admin can do this  ");

        }

        $requestRoles = $validatedData;

        // $removeRoles = array_diff($existingRoles, $requestRoles);
        // $user->removeRole($removeRoles);

        $user->syncRoles($requestRoles,[]);

        return redirect()->back()->with("success", 'Roles Updated!');
    }




}