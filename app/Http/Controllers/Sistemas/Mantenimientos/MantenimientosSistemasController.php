<?php

namespace App\Http\Controllers\Sistemas\Mantenimientos;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Sistemas\Hardware\HardwareAsignado;
use App\Models\Sistemas\Mantenimientos\CalendarioMantenimientos;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

class MantenimientosSistemasController extends Controller{

    public function index(Request $request){
        $Session = auth()->user();
        $FechaMantenimientos = CalendarioMantenimientos::get();

        $EquiposAsignados = HardwareAsignado::with([
            'Perfil' => function($prov) { //Relacion 1 a 1 De puestos
                $prov->select('id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat');
            },
            'Hardware' => function($articulo) { //Relacion 1 a 1 De puestos
                $articulo->select('id', 'Nombre', 'Marca');
            }
        ])->get(['id', 'IdUser', 'FechaAsignacion', 'SubArea', 'Ubicacion', 'Comentarios', 'Estatus', 'Hardware_id', 'Perfil_id']);

        $Session = Auth::user();
        $User = User::find($Session->id); //Accedo a los datos del usuario logueado
        $Autorizado = $User->hasAnyRole(['ONEPIECE', 'SISTEMAS']); //Busco si el suaurio tiene alguno de los siguientes Roles

        return Inertia::render('Sistemas/Mantenimientos/CalendarioMantenimientos', compact('Session', 'EquiposAsignados', 'FechaMantenimientos', 'Autorizado'));
    }

    public function store(Request $request){

        Validator::make($request->all(), [
            'IdUser' => ['required'],
            'start' => ['required','date'],
            'Tiempo' => ['required'],
            'Periodo' => ['required'],
            'Equipo' => ['required'],
        ])->validate();

        $request->start = Carbon::parse($request->start)->format('Y-m-d H:i');
        $Minutos = ($request->Tiempo * 60)+4;
        $request->end = Carbon::parse($request->start)->addMinutes($Minutos)->format('Y-m-d H:i');

        $Reservaciones = CalendarioMantenimientos::whereDate('start',Carbon::parse($request->start)->format('Y-m-d'))
        ->get(['id', 'start', 'end']);

        if(count($Reservaciones)){ //Valida que el dia tenga fechas registradas

            $NuevaFecha = Carbon::parse($request->start); //Convierto la fecha entrante en formato Carbon

            foreach ($Reservaciones as $val) { //Recorro las fechas registradas en ese dia
                //Convierto las fechas a formato Carbon
                $FecIni = Carbon::parse($val->start);
                $FecFin = Carbon::parse($val->end);

                //Verifico si la fecha solicitada ya se encuentra registrada
                if ($NuevaFecha->between($FecIni, $FecFin)) {
                    $Ini = Carbon::parse($val->start)->format('H:i');
                    $Fin = Carbon::parse($val->end)->format('H:i');
                    session()->flash('flash.type', 'Warning');
                    session()->flash('flash.message', 'Ya no se encuentra disponible el horario de '.$Ini.' a '.$Fin);
                    return redirect()->back();

                }else{ //Si esta disponible se registra
                    CalendarioMantenimientos::create([
                        'IdUser' => $request->IdUser,
                        'title' => $request->title,
                        'start' => $request->start,
                        'end' => $request->end,
                        'backgroundColor' => $request->backgroundColor,
                        'Periodo' => $request->Periodo,
                        'Tiempo' => $request->Tiempo,
                        'Estatus' => 1,
                        'Comentarios' => $request->Comentarios,
                        'Hardware_id' => $request->Hardware_id,
                        'Perfil_id' => $request->Perfil_id,
                    ]);
                    return redirect()->back();
                }
            }

        }else{ //Dia sin fechas asignadas
            CalendarioMantenimientos::create([
                'IdUser' => $request->IdUser,
                'title' => $request->title,
                'start' => $request->start,
                'end' => $request->end,
                'backgroundColor' => $request->backgroundColor,
                'Periodo' => $request->Periodo,
                'Tiempo' => $request->Tiempo,
                'Estatus' => 1,
                'Comentarios' => $request->Comentarios,
                'Hardware_id' => $request->Hardware_id,
                'Perfil_id' => $request->Perfil_id,
            ]);
            return redirect()->back();
        }
    }

    public function update(Request $request, $id){

        $Session = auth()->user();

        if ($request->has('id')) {

            switch ($request->metodo) {
                case 1:
                    $Minutos = ($request->Tiempo * 60)+14;
                    $request->end = Carbon::parse($request->start)->addMinutes($Minutos)->format('Y-m-d H:i');

                    $today = Carbon::now()->format('Y-m-d');
                    $later = Carbon::now()->add(29, 'day')->format('Y-m-d');

                    $Reservaciones = CalendarioMantenimientos::whereDate('start',Carbon::parse($request->start)->format('Y-m-d'))
                    ->get(['id', 'start', 'end']);

                    if(count($Reservaciones)){ //Valida que el dia tenga fechas registradas

                        $NuevaFecha = Carbon::parse($request->start); //Convierto la fecha entrante en formato Carbon

                        foreach ($Reservaciones as $val) { //Recorro las fechas registradas en ese dia
                            //Convierto las fechas a formato Carbon
                            $FecIni = Carbon::parse($val->start);
                            $FecFin = Carbon::parse($val->end);

                            //Verifico si la fecha solicitada ya se encuentra registrada
                            if ($NuevaFecha->between($FecIni, $FecFin)) {
                                $Ini = Carbon::parse($val->start)->format('H:i');
                                $Fin = Carbon::parse($val->end)->format('H:i');
                                session()->flash('flash.type', 'Warning');
                                session()->flash('flash.message', 'Ya no se encuentra disponible el horario de '.$Ini.' a '.$Fin);
                                return redirect()->back();
                            }else{ //Si esta disponible se registra
                                CalendarioMantenimientos::find($request->id)->update([
                                    'IdUser' => $Session->id,
                                    'start' => $request->start,
                                    'end' => $request->end,
                                ]);
                                return redirect()->back();
                            }
                        }

                    }else{ //Dia sin fechas asignadas
                        CalendarioMantenimientos::find($request->id)->update([
                            'IdUser' => $Session->id,
                            'start' => $request->start,
                            'end' => $request->end,
                        ]);
                        return redirect()->back();
                    }
                    break;

                case 2:
                    CalendarioMantenimientos::find($request->id)->update([
                        'Estatus' => 2,
                    ]);
                    return redirect()->back();
                break;
                case 3:
                    CalendarioMantenimientos::find($request->id)->update([
                        'Estatus' => 3,
                    ]);
                    return redirect()->back();
                break;
                case 4:
                    CalendarioMantenimientos::find($request->id)->update([
                        'Comentarios' => $request->Comentario,
                    ]);
                    return redirect()->back();
                break;
            }
        }

    }

    public function destroy($id)
    {
        //
    }
}
