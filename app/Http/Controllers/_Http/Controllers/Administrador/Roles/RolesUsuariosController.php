<?php

namespace App\Http\Controllers\Administrador\Roles;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;
use Spatie\Permission\Models\Role;

class RolesUsuariosController extends Controller{

    public function index(Request $request){

        $Users = User::with('roles')->get();
        $Roles = Role::get(['id', 'name']);

        return Inertia::render('Administrador/Roles/RolesUsuarios', compact('Users', 'Roles'));
    }

    public function store(Request $request){

        $user = User::find($request->User_id);
        // return $request;
        $user->roles()->sync($request->RolesUsu);

        return redirect()->back()->with('Roles Asignados Correctamente');
    }

}
