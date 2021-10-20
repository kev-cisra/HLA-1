<?php

namespace App\Http\Controllers\RecursosHumanos\PerfilesUsuarios;

use App\Http\Controllers\Controller;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Catalogos\JefesArea;
use App\Models\RecursosHumanos\Catalogos\Puestos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PerfilesUsuariosController extends Controller{

    public function index(Request $request){
        //Consulta de la información
        $PerfilesUsuarios = PerfilesUsuarios::with('PerfilPuesto','PerfilDepartamento', 'PerfilJefe')->get();

        // $Session = Auth::user();
        $Session = auth()->user();

        $Jefes = JefesArea::get(['id','Nombre']);
        $Puestos = Puestos::get(['id','Nombre']);
        $Departamentos = Departamentos::get(['id','Nombre']);

        //retorno de la vista retorno de la consulta de perfiles y sus filtros
        return Inertia::render('RecursosHumanos/PerfilesUsuarios/index', compact('PerfilesUsuarios', 'Jefes', 'Puestos', 'Departamentos', 'Session'));
    }

    public function store(Request $request){

        $Session = auth()->user();

        Validator::make($request->all(), [
            'IdUser' => ['required'],
            'IdEmp' => ['required'],
            'jefes_areas_id' => ['required'],
            'Empresa' => ['required'],
            'Nombre' => ['required'],
            'ApPat' => ['required'],
            'ApMat' => ['required'],
            'Curp' => ['required'],
            'Rfc' => ['required'],
            'Nss' => ['required'],
            'Direccion' => ['required'],
            'Telefono' => ['required'],
            'Cumpleaños' => ['required'],
            'FecIng' => ['required'],
            'Puesto_id' => ['required'],
            'Departamento_id' => ['required'],
        ])->validate();

        $Departamento = Departamentos::where('id', '=', $request->Departamento_id)->first();

        $Nick = User::create([
            'IdEmp' => $request->IdEmp,
            'name' => $request->Nombre.' '.$request->ApPat.' '.$request->ApMat,
            'Departamento' => $Departamento->Nombre,
            'password' => bcrypt($request->IdEmp)
        ]);

        PerfilesUsuarios::create([
            'IdUser' => $Session->id,
            'IdEmp' => $request->IdEmp,
            'Empresa' => $request->Empresa,
            'Nombre' => $request->Nombre,
            'ApPat' => $request->ApPat,
            'ApMat' => $request->ApMat,
            'Curp' => $request->Curp,
            'Rfc' => $request->Rfc,
            'Nss' => $request->Nss,
            'Direccion' => $request->Direccion,
            'Telefono' => $request->Telefono,
            'Cumpleaños' => $request->Cumpleaños,
            'FecIng' => $request->FecIng,
            'Antiguedad' => $request->Antiguedad,
            'DiasVac' => $request->DiasVac,
            'jefe_id' => $request->jefe_id,
            'user_id' => $Nick->id,
            'Puesto_id' => $request->Puesto_id,
            'Departamento_id' => $request->Departamento_id,
            'jefes_areas_id' => $request->jefes_areas_id,
        ]);

            return redirect()->back();
    }

    public function update(Request $request, $id){
        Validator::make($request->all(), [
            'IdUser' => ['required'],
            'IdEmp' => ['required'],
            'jefes_areas_id' => ['required'],
            'Empresa' => ['required'],
            'Nombre' => ['required'],
            'ApPat' => ['required'],
            'ApMat' => ['required'],
            'Curp' => ['required'],
            'Rfc' => ['required'],
            'Nss' => ['required'],
            'Direccion' => ['required'],
            'Telefono' => ['required'],
            'Cumpleaños' => ['required'],
            'FecIng' => ['required'],
            'Puesto_id' => ['required'],
            'Departamento_id' => ['required'],
        ])->validate();

        if ($request->has('id')) {
            PerfilesUsuarios::find($request->input('id'))->update($request->all());
            return redirect()->back();
        }
    }

    public function destroy(Request $request){
        if ($request->has('id')) {
            PerfilesUsuarios::find($request->input('id'))->delete();
            return redirect()->back();
        }
    }
}
