<?php

namespace App\Http\Controllers\RecursosHumanos\Vacaciones;

use App\Http\Controllers\Controller;
use App\Mail\RecursosHumanos\SolicitudDeVacacionesMailable;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Catalogos\JefesArea;
use App\Models\RecursosHumanos\Catalogos\Puestos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use App\Models\RecursosHumanos\Vacaciones\Vacaciones;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use stdClass;

use function PHPUnit\Framework\isNull;

class VacacionesDptoController extends Controller{

    //Estatus Vacaciones
    // 0 -> Solicitadas
    // 1 -> Autorizadas
    // 2 -> Rechazadas (Se regresn los dias solicitados)
    // 3 -> Peticion de cancelacion
    // 4 -> Vacaciones canceladas (Se regresan los dias)
    // 5 -> Peticion de cancelacio Rechazada

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
            }else{
                if($Session->id == 13){ //Pedro Asencion

                    $PerfilesUsuarios = PerfilesUsuarios::with(['jefe_perfiles','PerfilDepartamento', 'PerfilPuesto', 'jefe_perfiles.PerfilDepartamento', 'jefe_perfiles.PerfilPuesto', 'jefe_perfiles.perfiles_jefe.PerfilDepartamento', 'jefe_perfiles.perfiles_jefe.PerfilPuesto'])
                    ->where('Empresa', 'HILATURAS')
                    ->get();

                }else{//RecursoHumanos
                    $PerfilesUsuarios = PerfilesUsuarios::with(['PerfilDepartamento', 'PerfilPuesto'])
                    ->where('id', '>', 10)
                    ->get();
                }
            }

            $JefeDepto = true;

        }else{
            //Verifico si esta registrado en la tabla de jefes
            $EsJefe = JefesArea::where('IdEmp', '=', $Session->IdEmp)->first();
            $EsJefe != '' ? $JefeDepto = true :  $JefeDepto = false;
            //Obtengo el id de acuerdo al id de session logueado
            $PerfilId = PerfilesUsuarios::where('user_id', '=',  $Session->id)->first(['id']);
            //Obtengo los perfiles de acuerdo a su jefe asignado
            $PerfilesUsuarios = PerfilesUsuarios::with(['jefe_perfiles','PerfilDepartamento', 'PerfilPuesto', 'jefe_perfiles.PerfilDepartamento', 'jefe_perfiles.PerfilPuesto', 'jefe_perfiles.perfiles_jefe.PerfilDepartamento', 'jefe_perfiles.perfiles_jefe.PerfilPuesto'])
            ->where('id', '=' , $PerfilId->id)
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

        $Perfil = PerfilesUsuarios::where('IdEmp', '=', $request->IdEmp)->where('Empresa', '=', $request->Empresa)->first();

        $PerfilJefe = PerfilesUsuarios::where('id', '=', $Perfil->jefe_id)->first(['Nombre','ApPat','Correo']);

        $SolicitudVacaciones = Vacaciones::create([
            'IdUser' => $request->IdUser,
            'IdEmp' => $request->IdEmp,
            'Nombre' => $request->Nombre.' '.$request->ApPat.' '.$request->ApMat,
            'FechaInicio' => $request->FechaInicio,
            'FechaFin' => $request->FechaFin,
            'Comentarios' => $request->Comentarios,
            'Estatus' => $request->Estatus,
            'DiasTomados' => $request->DiasTomados,
            'DiasRestantes' => $request->DiasRestantes,
            'Perfil_id' => $Perfil->id,
        ]);

        PerfilesUsuarios::where('IdEmp', $request->IdEmp)->where('Empresa', '=', $request->Empresa)->update([
            'IdUser' => $request->IdUser,
            'DiasVac' => $request->DiasRestantes
        ]);

        if($request->JefeDepto == false){
            $DatosCorreo = new stdClass();
            //Asigno los valores correspondientes al correo
            $DatosCorreo->id = $SolicitudVacaciones->id;
            $DatosCorreo->IdEmp = $request->IdEmp;
            $DatosCorreo->Nombre = $request->Nombre.' '.$request->ApPat.' '.$request->ApMat;
            $DatosCorreo->FechaInicio = $request->FechaInicio;
            $DatosCorreo->FechaFin = $request->FechaFin;
            $DatosCorreo->DiasTomados = $request->DiasTomados;

            if(isset($PerfilJefe->Correo)){
                $correo = new SolicitudDeVacacionesMailable($DatosCorreo);
                Mail::to($PerfilJefe->Correo)
                ->send($correo);

                $CorreoJefe = '';

                if (Mail::failures()) {

                    session()->flash('flash.type', 'Warning');
                    session()->flash('flash.message', 'Error al Enviar el correo');

                }else{
                    session()->flash('flash.type', 'Success');
                    session()->flash('flash.message', 'Se envio un correo a '.$PerfilJefe->Nombre.' '.$PerfilJefe->ApPat.' para que autorize tus vacaciones');
                }
            }else{
                session()->flash('flash.type', 'Warning');
                session()->flash('flash.message', 'No se envio Correo al jefe asignado');
            }

        }

        return redirect()->back();
    }

    public function update(Request $request, $id){
        switch ($request->Tipo) {
            case 1: //Autoriza Vacaciones
                Vacaciones::find($request->id)->update([
                    'Estatus' => 1, //Autorizada
                ]);
                return redirect()->back();
                break;

            case 2: //Rechaza vacaciones

                Vacaciones::find($request->id)->update([
                    'Estatus' => 2, //Rechazada
                ]);

                $Vacaciones = PerfilesUsuarios::where('id', '=', $request->Perfil_id)->first('DiasVac');
                //Devuelven los dias tomados
                PerfilesUsuarios::where('id', '=', $request->Perfil_id)->update([
                    'DiasVac' => $Vacaciones->DiasVac + $request->DiasTomados,
                ]);

                return redirect()->back();
                break;

            case 3: //Envia peticion de Devolucion de dias
                // return $request;
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
