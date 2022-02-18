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
            ->where('vacaciones.Estatus', '!=', 1)
            ->join('puestos', 'perfiles_usuarios.Puesto_id', '=', 'puestos.id')
            ->join('vacaciones', 'perfiles_usuarios.IdEmp', '=', 'vacaciones.IdEmp')
            ->get();

        return Inertia::render('RecursosHumanos/CancelaVacaciones/index', compact('Vacaciones'));
    }

    public function update(Request $request, $id){

        //Obtiene el Num de empleado correspondiente a la solicitud de vacaciones
        $Perfil = PerfilesUsuarios::where('IdEmp', '=', $request->IdEmp)->first();
        //Obtienes el id de la peticion de vacaciones
        $DiasRest = Vacaciones::select('id','DiasRestantes')->find($request->id);


        switch($request->metodo){
            case 1:
                // return $request;
                Vacaciones::where('id', '=' ,$request->id)->update([
                    'Estatus' => 1,
                ]);
                return redirect()->back()->with('message', 'Perfil y Usuario Creados Correctamente');
                break;
            case 2: //Caso 1 Cancelacion de vacaciones aprovada
                //Regresa los dias de vacaciones correspondietes al perfil
                PerfilesUsuarios::find($Perfil->id)->update([
                    'DiasVac' => $Perfil->DiasVac + $request->DiasTomados,
                ]);

                //Regresa los dias de vacaciones correspondientes al historico de vacaciones
                Vacaciones::find($request->id)->update([
                    'DiasRestantes' => $DiasRest->DiasRestantes + $request->DiasTomados,
                    'Estatus' => 3,
                ]);

                return redirect()->back()->with('message', 'Perfil y Usuario Creados Correctamente');
                break;

            case 3:
                Vacaciones::find($request->id)->update([
                    'Estatus' => 4,
                ]);

                return redirect()->back()->with('message', 'Perfil y Usuario Creados Correctamente');
                break;
        }


    }

    public function destroy($id){

    }
}
