<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(){
        if (auth()->user()->hasPermissionTo('show user')){
            $users=User::all();
            $roles=Role::all();
            return view('users.index',['users'=>$users,'roles'=>$roles]);
        }

        return "not permisttion to show  users";

    }
    public function assignRole(Request $request , User $user){

$valdata=$request->validate(["roles"=>'array|min:1']);
if (!$user->hasRole('admin') && in_array('admin',$valdata['roles'])) {
    return redirect()->back();}
     if(!$user->hasRoles){
            $user->assignRole($valdata['roles']);
        return redirect()->back();
    }


}
}