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
use Carbon\Carbon;

class PerfilesUsuariosController extends Controller{

    public $hoy;

    public function index(){
        //Consulta de la información
        $PerfilesUsuarios = PerfilesUsuarios::with('PerfilPuesto','PerfilDepartamento', 'PerfilJefe')->get();

        //Calculo de Antiguedad y dias de vacaciones Correspondientes
        $DiasVac = 0;

        $this->hoy = Carbon::now();
        $this->hoy->format('Y-m-d');
        $fecha = $this->hoy;

        $vacaciones = PerfilesUsuarios::get(['IdEmp', 'FecIng', 'Antiguedad', 'DiasVac']);

        foreach ($vacaciones as  $value) {
            //Conversion de fecha de ingreso a formato de Carbon
            $FechaIngreso = Carbon::parse($value->FecIng);
            //Calculo de años de antiguedad
            $Antiguedad = Carbon::now()->diffInYears($FechaIngreso);

            // if($fecha == $value->FecIng){
                PerfilesUsuarios::where('IdEmp', $value->IdEmp)->update(['Antiguedad' => $Antiguedad]);
            // }

            //Dia y mes de aniversario
            // $Aniversario = $fecha->format('m-d');
            // $Aniv = $FechaIngreso->format('m-d');
        }

        $Session = Auth::user();
        $Jefes = JefesArea::get(['id','Nombre']);
        $Puestos = Puestos::get(['id','Nombre']);
        $Departamentos = Departamentos::get(['id','Nombre']);

        //retorno de la vista retorno de la consulta de perfiles y sus filtros
        return Inertia::render('RecursosHumanos/PerfilesUsuarios/index', compact('PerfilesUsuarios', 'Jefes', 'Puestos', 'Departamentos', 'Session', 'fecha'));
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
