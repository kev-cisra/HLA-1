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

    public function create(){

    }

    public function store(Request $request){

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

        PerfilesUsuarios::create($request->all());

        $Departamento = Departamentos::where('id', '=', $request->Departamento_id)->first();

        $Nick = User::create([
            'IdEmp' => $request->IdEmp,
            'name' => $request->Nombre.' '.$request->ApPat.' '.$request->ApMat,
            'Departamento' => $Departamento->Nombre,
            'password' => bcrypt($request->IdEmp)
        ]);

        $User = User::latest('id')->first();
        $Perfil = PerfilesUsuarios::latest('id')->first();

        if(!empty($User) || !empty($Perfil)){
            PerfilesUsuarios::find($Perfil->id)->update(['user_id' => $User->id]);
            return redirect()->back()->with('message', 'Perfil y Usuario Creados Correctamente');
        }else{
            return redirect()->back()->with('message', 'Error');
        }
    }

    public function show($id){

    }

    public function edit($id){

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
