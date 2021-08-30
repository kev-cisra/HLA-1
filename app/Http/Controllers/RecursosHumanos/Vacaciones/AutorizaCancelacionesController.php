<?php

namespace App\Http\Controllers\RecursosHumanos\Vacaciones;

use App\Http\Controllers\Controller;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use App\Models\RecursosHumanos\Vacaciones\Vacaciones;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;


class AutorizaCancelacionesController extends Controller{

    public function index(){

        $Session = Auth::user();

        $Vacaciones = PerfilesUsuarios::select(
            'perfiles_usuarios.IdEmp AS IdEmp',
            'perfiles_usuarios.Nombre AS Nombre',
            'perfiles_usuarios.ApPat AS ApPat',
            'perfiles_usuarios.ApMat AS ApMat',
            'perfiles_usuarios.DiasVac AS DiasVac',
            'puestos.Nombre AS Puesto',
            'perfiles_usuarios.Empresa AS Empresa',
            'vacaciones.id AS id',
            'vacaciones.FechaInicio AS FechaInicio',
            'vacaciones.FechaFin AS FechaFin',
            'vacaciones.Comentarios AS Comentarios',
            'vacaciones.DiasTomados AS DiasTomados',
            'vacaciones.DiasRestantes AS DiasRestantes',
            'vacaciones.MotivoCancelacion AS MotivoCancelacion',
            'vacaciones.Estatus AS Estatus')
            ->where('vacaciones.Estatus', 2)
            ->join('puestos', 'perfiles_usuarios.Puesto_id', '=', 'puestos.id')
            ->join('vacaciones', 'perfiles_usuarios.IdEmp', '=', 'vacaciones.IdEmp')
            ->get();

        return Inertia::render('RecursosHumanos/CancelaVacaciones/index', compact('Vacaciones'));
    }


    public function create(){

    }

    public function store(Request $request){

    }

    public function show($id){

    }

    public function edit($id){

    }

    public function update(Request $request, $id){

        $DiasRest = Vacaciones::find($request->id)->first();
        $Dias = $DiasRest->DiasRestantes;

        Vacaciones::find($request->id)->update([
            'DiasRestantes' => $request->DiasTomados + $Dias,
            // 'Estatus' => 3,
        ]);

        return $request;
    }

    public function destroy($id){

    }
}
