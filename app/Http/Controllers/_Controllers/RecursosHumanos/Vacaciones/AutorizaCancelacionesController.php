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
            'perfiles_usuarios.id AS PerfilId',
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
            'vacaciones.Estatus AS Estatus',
            'vacaciones.Perfil_id AS Perfil_id')
            ->where('vacaciones.Estatus', '=', 0)
            ->orWhere('vacaciones.Estatus', '=', 3)
            ->join('puestos', 'perfiles_usuarios.Puesto_id', '=', 'puestos.id')
            ->join('vacaciones', 'perfiles_usuarios.id', '=', 'vacaciones.Perfil_id')
            ->get();

        return Inertia::render('RecursosHumanos/CancelaVacaciones/index', compact('Vacaciones'));
    }

    public function update(Request $request, $id){

        //Obtiene el Num de empleado correspondiente a la solicitud de vacaciones
        $Perfil = PerfilesUsuarios::where('IdEmp', '=', $request->IdEmp)->first();
        //Obtienes el id de la peticion de vacaciones
        $DiasRest = Vacaciones::select('id','DiasRestantes')->find($request->id);


        switch($request->metodo){
            case 1: //Autoriza Vacaciones
                // return $request;
                Vacaciones::where('id', '=' ,$request->id)->update([
                    'Estatus' => 1,
                ]);
                return redirect()->back()->with('message', 'Vacaciones Autorizadas');
                break;
            case 2: //Caso 2 Cancelacion de vacaciones aprovadas
                //Regresa los dias de vacaciones correspondietes al perfil
                PerfilesUsuarios::find($Perfil->id)->update([
                    'DiasVac' => $Perfil->DiasVac + $request->DiasTomados,
                ]);

                //Regresa los dias de vacaciones correspondientes al historico de vacaciones
                Vacaciones::find($request->id)->update([
                    'DiasRestantes' => $DiasRest->DiasRestantes + $request->DiasTomados,
                    'Estatus' => 4,
                ]);

                return redirect()->back()->with('message', 'Perfil y Usuario Creados Correctamente');
                break;

            case 3: //Peticion de canlecacion rechazada
                Vacaciones::find($request->id)->update([
                    'Estatus' => 5,
                ]);

                return redirect()->back()->with('message', 'Peticion rechazada');
                break;
        }


    }

    public function destroy($id){

    }
}
