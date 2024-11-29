<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index(){

        $permissions=Permission::with('users')->get();

        return view('permissions.index',['permissions'=>$permissions]);

    }

    public function create (Request $request){
        return view('permissions.create');
    }
    
    public function store(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);
        $guardName = $request->user()->hasRole('admin') ? 'admin' : 'web';

        // Create the permission
        $permission=Permission::create([
            'name' => $validated['name'],
            'guard_name' => "web",
        ]);

     // Retrieve the super-admin role
$role = Role::where('name', 'super-admin')->first();

// Check if the role exists before assigning the permission
if ($role) {
    $role->givePermissionTo($permission);
}
 
        // Redirect with a success message
        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }
    
    public function edit (Request $request ,Permission $permission){
        return view('permissions.edit',['permission'=>$permission]);
    }

    public function destroy(Permission $permission){

        // dd( $permission);
        $permission->delete();
        return redirect()->back()->with('success','The Permission deleted succesflly!');
    }

   
}
