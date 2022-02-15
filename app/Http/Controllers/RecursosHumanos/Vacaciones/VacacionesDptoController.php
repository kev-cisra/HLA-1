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

class VacacionesDptoController extends Controller
{
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

        $PerfilSession = PerfilesUsuarios::find($Session->id);

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

        }else{
            $PerfilesUsuarios = PerfilesUsuarios::with(['jefe_perfiles','PerfilDepartamento', 'PerfilPuesto', 'jefe_perfiles.PerfilDepartamento', 'jefe_perfiles.PerfilPuesto', 'jefe_perfiles.perfiles_jefe.PerfilDepartamento', 'jefe_perfiles.perfiles_jefe.PerfilPuesto'])
            ->where('id', $Session->id)
            ->get();
        }

        //Historico de Vacaciones
        if($request->IdEmp){
            $Vacaciones = Vacaciones::where('IdEmp', '=', $request->IdEmp)
            ->get(['id', 'IdUser', 'IdEmp', 'Nombre', 'FechaInicio', 'FechaFin', 'Comentarios', 'Estatus', 'DiasTomados', 'DiasRestantes', 'MotivoCancelacion']);
        }else{
            $Vacaciones = 1;
        }

        //retorno de la vista retorno de la consulta de perfiles y sus filtros
        return Inertia::render('RecursosHumanos/Vacaciones/index', compact('Session','Autorizado', 'PerfilesUsuarios', 'PerfilSession', 'Vacaciones'));
    }

    public function store(Request $request){

        Validator::make($request->all(), [
            'FechaInicio' => ['required'],
            'FechaFin' => ['required'],
            'DiasTomados' => ['required'],
        ])->validate();

        Vacaciones::create([
            'IdUser' => $request->IdUser,
            'IdEmp' => $request->IdEmp,
            'Nombre' => $request->Nombre.' '.$request->ApPat.' '.$request->ApMat,
            'FechaInicio' => $request->FechaInicio,
            'FechaFin' => $request->FechaFin,
            'Comentarios' => $request->Comentarios,
            'Estatus' => 1,
            'DiasTomados' => $request->DiasTomados,
            'DiasRestantes' => $request->DiasRestantes,
        ]);

        PerfilesUsuarios::where('IdEmp', $request->IdEmp)->update([
            'IdUser' => $request->IdUser,
            'DiasVac' => $request->DiasRestantes
        ]);

        return redirect()->back()->with('message', 'Exito');
    }

    public function update(Request $request, $id){
        Validator::make($request->all(), [
            'Motivo' => ['required'],
        ])->validate();

        Vacaciones::find($request->id)->update([
            'MotivoCancelacion' => $request->Motivo,
            'Estatus' => 2,
        ]);
        return redirect()->back();
    }

    public function destroy($id){

    }
}
