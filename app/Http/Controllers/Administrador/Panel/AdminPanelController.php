<?php

namespace App\Http\Controllers\Administrador\Panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminPanelController extends Controller{

    public function index(Request $request, Role $role){
        $Session = auth()->user(); //Obtengo el Usuario logueado

        if($request->id != 0){
            // $RolPermisos = Role::with('permissions')->where('id', $request->id)->get();
            $RolPermisos = Permission::all()->pluck('name', 'id');
            $role->load('permissions');
        }else{
            $RolPermisos = 1;
        }

        $Roles = Role::get(['id', 'name']);
        $Permisos = Permission::get(['id', 'name']);

        return Inertia::render('Plantilla2', compact('Session', 'Roles'));
    }

    public function store(Request $request){

        switch ($request->Tipo) {
            case 1:
              /*   return $request; */
                $permission = Permission::create(['guard_name' => 'web', 'name' => $request->NombreRol]);
                /* $role = Role::create(['guard_name' => 'web', 'name' => $request->NombreRol]); */
                break;

            case 2:
                //return $request;
                $role = Role::find(16);
                $role->givePermissionTo(22);
                $permission = Permission::create(['guard_name' => 'web', 'name' => $request->NombrePermiso]);
                break;
        }

        return redirect()->back()->with('Rol creado Exitosamente');
    }
}
