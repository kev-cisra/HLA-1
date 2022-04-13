<?php

namespace App\Http\Controllers\Administrador\Roles;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use stdClass;

class SpatieController extends Controller{

    public function index(Request $request, Role $role){
        $Session = auth()->user(); //Obtengo el Usuario logueado

        if($request->id != 0){
            $RolPermisos = Role::with('permissions')->where('id', $request->id)->first();
            // $RolPermisos = Permission::all()->pluck('name', 'id');
            // $role->load('permissions');
        }else{
            $RolPermisos = new stdClass();
        }

        $Roles = Role::get(['id', 'name']);
        $Permisos = Permission::get(['id', 'name']);

        return Inertia::render('Administrador/Roles/RolesAndPermissions', compact('Session', 'Roles', 'Permisos', 'RolPermisos'));
    }

    public function store(Request $request){

        switch ($request->Tipo) {
            case 1:
                $Role = Role::create(['guard_name' => 'web', 'name' => $request->NombreRol]);
                return redirect()->back()->with('Rol creado Exitosamente');
                break;
            case 2:
                // return $request;
                $permission = Permission::create(['guard_name' => 'web', 'name' => $request->NombrePermiso]);
                return redirect()->back()->with('Permiso creado Exitosamente');
                break;
        }
    }

    public function update(Request $request, $id){
        $Rol = Role::find($request->Rol_id);
        $Rol->syncPermissions($request->permissions);
        return redirect()->back();
    }
}
