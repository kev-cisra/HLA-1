<?php

namespace App\Http\Controllers\RecursosHumanos\Vacaciones;

use App\Http\Controllers\Controller;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Catalogos\JefesArea;
use App\Models\RecursosHumanos\Catalogos\Puestos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use App\Models\RecursosHumanos\Vacaciones\Vacaciones;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use stdClass;

use function PHPUnit\Framework\isNull;

class VacacionesDptoController extends Controller{

    public function index(Request $request){

        $hoy= Carbon::now();
        $mes = $hoy->format('n');
        $anio = $hoy->format('Y');

        //Catalogos
        $Jefes = JefesArea::get(['id','Nombre']);
        $Puestos = Puestos::get(['id','Nombre']);
        $Departamentos = Departamentos::get(['id','Nombre']);

        //Consulta para obtener el Numero de empleado de la session
        $Session = Auth::user();
        $User = User::find($Session->id); //Accedo a los datos del usuario logueado
        $Autorizado = $User->hasAnyRole(['ONEPIECE', 'RecursosHumanos']); //Busco si el suaurio tiene alguno de los siguientes Roles

        $PerfilSession = PerfilesUsuarios::where('user_id', '=',$Session->id)->first();

        //Generacion de Consulta de Perfiles
        if($Autorizado == true){
            if($User->hasRole('ONEPIECE') == true){ //Admin
                $PerfilesUsuarios = PerfilesUsuarios::with(['PerfilDepartamento', 'PerfilPuesto'])
                ->get();
            }else{ //RecursoHumanos
                $PerfilesUsuarios = PerfilesUsuarios::with(['PerfilDepartamento', 'PerfilPuesto'])
                ->where('id', '>', 10)
                ->get();
            }

            $JefeDepto = true;

        }else{
            //Verifico si esta registrado en la tabla de jefes
            $EsJefe = JefesArea::where('IdEmp', '=', $Session->IdEmp)->first();
            $EsJefe != '' ? $JefeDepto = true :  $JefeDepto = false;
            $PerfilesUsuarios = PerfilesUsuarios::with(['jefe_perfiles','PerfilDepartamento', 'PerfilPuesto', 'jefe_perfiles.PerfilDepartamento', 'jefe_perfiles.PerfilPuesto', 'jefe_perfiles.perfiles_jefe.PerfilDepartamento', 'jefe_perfiles.perfiles_jefe.PerfilPuesto'])
            ->where('id', $Session->id)
            ->get();
        }

        //Historico de Vacaciones
        $MisVacaciones = Vacaciones::where('Perfil_id', '=', $Session->id)
        ->get(['id', 'IdUser', 'IdEmp', 'Nombre', 'FechaInicio', 'FechaFin', 'Comentarios', 'Estatus', 'DiasTomados', 'DiasRestantes', 'MotivoCancelacion', 'Perfil_id']);
        //Consulta de vacaciones por empleado
        if($request->id){
            $Vacaciones = Vacaciones::where('Perfil_id', '=', $request->id)
            ->get(['id', 'IdUser', 'IdEmp', 'Nombre', 'FechaInicio', 'FechaFin', 'Comentarios', 'Estatus', 'DiasTomados', 'DiasRestantes', 'MotivoCancelacion', 'Perfil_id']);
        }else{
            $Vacaciones = new stdClass();
        }

        //retorno de la vista retorno de la consulta de perfiles y sus filtros
        return Inertia::render('RecursosHumanos/Vacaciones/index', compact('Session','Autorizado', 'JefeDepto', 'PerfilesUsuarios', 'PerfilSession', 'MisVacaciones' ,'Vacaciones'));
    }

    public function store(Request $request){

        Validator::make($request->all(), [
            'FechaInicio' => ['required'],
            'FechaFin' => ['required'],
            'DiasTomados' => ['required'],
        ])->validate();

        $Perfil_id = PerfilesUsuarios::where('IdEmp', '=', $request->IdEmp)->where('Empresa', '=', $request->Empresa)->first();

        Vacaciones::create([
            'IdUser' => $request->IdUser,
            'IdEmp' => $request->IdEmp,
            'Nombre' => $request->Nombre.' '.$request->ApPat.' '.$request->ApMat,
            'FechaInicio' => $request->FechaInicio,
            'FechaFin' => $request->FechaFin,
            'Comentarios' => $request->Comentarios,
            'Estatus' => $request->Estatus,
            'DiasTomados' => $request->DiasTomados,
            'DiasRestantes' => $request->DiasRestantes,
            'Perfil_id' => $Perfil_id->id,
        ]);

        PerfilesUsuarios::where('IdEmp', $request->IdEmp)->where('Empresa', '=', $request->Empresa)->update([
            'IdUser' => $request->IdUser,
            'DiasVac' => $request->DiasRestantes
        ]);

        return redirect()->back()->with('message', 'Exito');
    }

    public function update(Request $request, $id){
        switch ($request->Tipo) {
            case 1:
                Vacaciones::find($request->id)->update([
                    'Estatus' => 1, //Autorizada
                ]);
                return redirect()->back();
                break;

            case 2:
                return $request;
                Vacaciones::find($request->id)->update([
                    'Estatus' => 2, //Rechazada
                ]);
                return redirect()->back();
                break;

            case 3:
                Validator::make($request->all(), [
                    'Motivo' => ['required'],
                ])->validate();

                Vacaciones::find($request->id)->update([
                    'MotivoCancelacion' => $request->Motivo,
                    'Estatus' => 3, //En proceso de Cancelacion
                ]);
                return redirect()->back();
                break;
        }
    }

    public function destroy($id){
    }
}
