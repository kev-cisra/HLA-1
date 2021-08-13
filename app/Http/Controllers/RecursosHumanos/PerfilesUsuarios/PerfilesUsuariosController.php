<?php

namespace App\Http\Controllers\RecursosHumanos\PerfilesUsuarios;

use App\Http\Controllers\Controller;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Catalogos\JefesArea;
use App\Models\RecursosHumanos\Catalogos\Puestos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PerfilesUsuariosController extends Controller{

    public function index(){

        $PerfilesUsuarios = PerfilesUsuarios::with('PerfilPuesto','PerfilDepartamento', 'PerfilJefe')->get();

/*         $PerfilesUsuarios = PerfilesUsuarios::with([
            'PerfilPuesto' => function($puesto){
                $puesto->select(['id','Nombre']);
            },
            'PerfilDepartamento' => function($departamento){
            $departamento->select('Nombre');
            },
            'PerfilJefe' => function($jefe){
                $jefe->select('Nombre');
            },
            ])->get(['id', 'IdUser', 'IdEmp', 'Empresa','Nombre','ApPat', 'ApMat', 'Curp', 'Rfc', 'Nss', 'Direccion',
            'Telefono', 'Cumpleaños','FecIng', 'Antiguedad', 'DiasVac', 'jefe_id', 'user_id', 'Puesto_id', 'Departamento_id']); */


        $Session = Auth::user();
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
        return redirect()->back()
            ->with('message', 'Post Created Successfully.');

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
