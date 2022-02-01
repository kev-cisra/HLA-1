<?php

namespace App\Http\Controllers\Administrador\Panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminPanelController extends Controller{

    public function index(){

        $Roles = Role::get(['id', 'name']);
        return Inertia::render('Plantilla2', compact('Roles'));
    }

    public function store(Request $request){
        $role = Role::create(['guard_name' => 'web', 'name' => $request->NombreRol]);

        return redirect()->back()->with('Rol creado Exitosamente');
    }
}
