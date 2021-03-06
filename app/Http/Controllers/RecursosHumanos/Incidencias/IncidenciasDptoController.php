<?php

namespace App\Http\Controllers\RecursosHumanos\Incidencias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Catalogos\JefesArea;
use App\Models\RecursosHumanos\Catalogos\Puestos;
use App\Models\RecursosHumanos\Incidencias\Incidencias;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Carbon\Carbon;
class IncidenciasDptoController extends Controller{

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

        //Generacion de Consulta de Perfiles
        if($Autorizado == true){
            if($User->hasRole('ONEPIECE') == true){ //Admin
                $PerfilesUsuarios = PerfilesUsuarios::with(['PerfilDepartamento', 'PerfilPuesto'])
                ->get();
            }else{ //RecursoHumanos

                if($Session->id == 13){ //Pedro Asencion

                    $PerfilesUsuarios = PerfilesUsuarios::with(['jefe_perfiles','PerfilDepartamento', 'PerfilPuesto', 'jefe_perfiles.PerfilDepartamento', 'jefe_perfiles.PerfilPuesto', 'jefe_perfiles.perfiles_jefe.PerfilDepartamento', 'jefe_perfiles.perfiles_jefe.PerfilPuesto'])
                    ->where('Empresa', 'HILATURAS')
                    ->get();

                }else{
                    $PerfilesUsuarios = PerfilesUsuarios::with(['PerfilDepartamento', 'PerfilPuesto'])
                    ->where('id', '>', 10)
                    ->get();
                }
            }
        }else{
            //Obtengo el id de acuerdo al id de session logueado
            $PerfilId = PerfilesUsuarios::where('user_id', '=',  $Session->id)->first(['id']);
            //Obtengo los perfiles de acuerdo a su jefe asignado
            $PerfilesUsuarios = PerfilesUsuarios::with(['jefe_perfiles','PerfilDepartamento', 'PerfilPuesto', 'jefe_perfiles.PerfilDepartamento', 'jefe_perfiles.PerfilPuesto', 'jefe_perfiles.perfiles_jefe.PerfilDepartamento', 'jefe_perfiles.perfiles_jefe.PerfilPuesto'])
            ->where('id', $PerfilId->id)
            ->get();
        }


        if(!empty($request->id)){
            $Incidencias = Incidencias::where('perfiles_usuarios_id', '=', $request->id)
            ->whereYear('Fecha', '=', $anio)
            ->get(['id', 'IdUser', 'IdEmp', 'TipoMotivo', 'Fecha', 'FechaFin', 'Comentarios', 'perfiles_usuarios_id']);
        }else{
            $Incidencias = Incidencias::get(['id', 'IdUser', 'IdEmp', 'TipoMotivo', 'Fecha', 'FechaFin', 'Comentarios', 'perfiles_usuarios_id']);
        }

        return Inertia::render('RecursosHumanos/Incidencias/index', compact('PerfilesUsuarios', 'Autorizado', 'Jefes', 'Puestos', 'Departamentos', 'Session', 'Incidencias'));
    }

    public function store(Request $request){

        Validator::make($request->all(), [
            'Tipo' => ['required'],
            'Fecha' => ['required'],
            'Comentarios' => ['required'],
        ])->validate();

        Incidencias::create([
            'IdUser' => $request->IdUser,
            'IdEmp' => $request->IdEmp,
            'TipoMotivo' => $request->Tipo,
            'Fecha' => $request->Fecha,
            'FechaFin' => $request->FechaFin,
            'Comentarios' => $request->Comentarios,
            'perfiles_usuarios_id' => $request->id,
        ]);

        return redirect()->back()->with('message', 'Exito');
    }

    public function update(Request $request, $id){

        Validator::make($request->all(), [
            'Tipo' => ['required'],
            'Fecha' => ['required'],
            'Comentarios' => ['required'],
        ])->validate();

        switch ($request->metodo) {
            case 1: //Actualizacion de estatuz a Confirmado
                Incidencias::find($request->id)->update([
                    'IdEmp' => $request->IdEmp,
                    'TipoMotivo' => $request->Tipo,
                    'Fecha' => $request->Fecha,
                    'FechaFin' => $request->FechaFin,
                    'Comentarios' => $request->Comentarios,
                ]);
                return redirect()->back();
                break;
        }
    }

}
