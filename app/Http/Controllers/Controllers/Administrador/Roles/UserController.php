<?php

namespace App\Http\Controllers\Administrador\Roles;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller{

    public function edit(User $user){
        $roles = Role::all();
        // return $user;
        return view('admin.users.edit', compact('user','roles'));
    }

    public function update(Request $request, User $user){
        $user->roles()->sync($request->roles);
        return redirect()->route('admin.users.edit', $user)->with('info', 'Se asignaron los roles correctamente');
    }
}
