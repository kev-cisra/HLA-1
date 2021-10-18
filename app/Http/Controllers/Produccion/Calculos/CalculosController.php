<?php

namespace App\Http\Controllers\Produccion\Calculos;

use App\Http\Controllers\Controller;
use App\Models\Produccion\carga;
use App\Models\Produccion\catalogos\procesos;
use App\Models\Produccion\turnos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SebastianBergmann\Environment\Console;

class CalculosController extends Controller
{
    //
    public function store(Request $request)
    {
        //pone la hora de inicio y fin para consultar
        $hIni = ' 07:00:00';
        if ($request->depa == 7 & !empty(Carbon::createFromDate($request->fecha)->isDST())) {
            $hIni = ' 09:00:00';
        }else if($request->depa == 7 & empty(Carbon::createFromDate($request->fecha)->isDST())) {
            $hIni = ' 08:00:00';
        }


        //dias para consultar
        $hoy = Carbon::create($request->fecha.$hIni)->format('Y-m-d H:i:s');
        $mañana = Carbon::create($request->fecha.$hIni)->addDays(1)->format('Y-m-d H:i:s');
        $semana = date('Y',strtotime($request->fecha)).'-W'.date('W',strtotime($request->fecha));
        $fechas = ['hoy' => $hoy, 'mañana' => $mañana, 'semana' => $semana];

        $calcula = procesos::where('departamento_id', '=', $request->depa)
                    ->where('tipo', '=', '3')
                    ->with([
                        'formulas' => function($fo){
                            $fo -> select('id', 'proc_rela', 'maq_pros_id', 'proceso_id');
                        }
                    ])
                    ->get(['id', 'nompro', 'tipo', 'operacion']);
        //muestra las operaciones
        foreach ($calcula as $ope) {
            //dependiendo del tipo de operacion
            switch ($ope->operacion) {
                case 'sm_d':
                    //$this->sm_d($ope, $fechas);
                    break;
                case 'sm_dc':
                    //$this->sm_dc($ope, $fechas);
                    break;
                case 'sm_t':
                    //$this->sm_t($ope, $request->depa, $fechas);
                    break;
                case 'sm_tc':
                    $this->sm_tc($ope, $request->depa, $fechas);
                    break;
            }
        }

        return 'Listo';

        /* return redirect()->back()
            ->with('message', 'Post Created Successfully.'); */
    }
    /************************************** Guardado o Actualizado ************************************/
    public function gua_act($data){
        //consulta si existe el dato
        //echo $data;
    }

    /************************************** Operaciones ***********************************************/
    //operacion suma del dia
    public function sm_d($val, $fechas){
        $fs = 0;
        $fc = 0;
        //recorrido de formulas
        foreach ($val->formulas as $value) {

            $proce_id = $value->proceso_id;
            $maq_id = $value->maq_pros_id;
            //Consulta para la suma
            $suma = carga::whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
            ->where(function($qm) use ($maq_id){
                $qm ->whereNotNull('maq_pro_id')
                    -> where('maq_pro_id', '=', $maq_id);
            })
            ->orWhere(function($q) use ($proce_id){
                $q -> whereNull('maq_pro_id')
                    ->where('proceso_id', '=', $proce_id);
            })
            ->sum('valor');
            //Consulta de paquetes contados
            $cuenta = carga::whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
            ->where(function($qm) use ($maq_id){
                $qm ->whereNotNull('maq_pro_id')
                    -> where('maq_pro_id', '=', $maq_id);
            })
            ->orWhere(function($q) use ($proce_id){
                $q -> whereNull('maq_pro_id')
                    ->where('proceso_id', '=', $proce_id);
            })
            ->count('valor');
            //variablesde operaciones
            $fs += $suma;
            $fc += $cuenta;
            //print($fs.' | '.$cuenta.' / ');
        }

        echo $val->nompro.' | '.$fs.' | '.$fc.'  fin suma dia || ';
        $this->gua_act($val);
        return 'sm_d';
    }

    //operacion suma dia clave
    public function sm_dc($val, $fechas){
        //recorrido de formulas
        foreach ($val->formulas as $value) {
            $proce_id = $value->proceso_id;
            $maq_id = $value->maq_pros_id;
            $claves = carga::where('maq_pro_id', '=', $maq_id)
            ->whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
            ->with([
                'clave' => function($cla){
                    $cla ->withTrashed()
                    -> select('id', 'CVE_ART', 'DESCR');
                }
            ])
            ->distinct()
            ->get(['clave_id']);
            $fs = 0;
            $fc = 0;
            foreach ($claves as $cl) {
                //suma
                $suma = carga::whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
                    ->where('clave_id', '=', $cl->clave_id)
                    ->where(function($qm) use ($maq_id){
                        $qm ->whereNotNull('maq_pro_id')
                            -> where('maq_pro_id', '=', $maq_id);
                    })
                    ->orWhere(function($q) use ($proce_id){
                        $q -> whereNull('maq_pro_id')
                            ->where('proceso_id', '=', $proce_id);
                    })
                    ->sum('valor');

                //catidad
                $cuenta = carga::whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
                    ->where('clave_id', '=', $cl->clave_id)
                    ->where(function($qm) use ($maq_id){
                        $qm ->whereNotNull('maq_pro_id')
                            -> where('maq_pro_id', '=', $maq_id);
                    })
                    ->orWhere(function($q) use ($proce_id){
                        $q -> whereNull('maq_pro_id')
                            ->where('proceso_id', '=', $proce_id);
                    })
                    ->count('valor');
                //resultado
                $fs += $suma;
                $fc += $cuenta;
                print($val->nompro.' | '.$cl->clave->CVE_ART.' | '.$suma.' | '.$cuenta.' - ');
            }
        }
        echo ' fin suma clave dia || ';
        return 'sm_dc';

    }

    //operacion suma turno
    public function sm_t($val, $dep, $fechas){
        //se consultan los turnos que existe menos el turno vacio
        $turnos = turnos::where('departamento_id', '=', $dep)
            ->where('nomtur', '!=', 'Vacío')
            ->get();
        //recorrido del turno
        foreach ($turnos as $tur) {
            //variablesde operaciones
            $fs = 0;
            $fc = 0;
            //recorrido de formulas
            foreach ($val->formulas as $value) {
                $proce_id = $value->proceso_id;
                $maq_id = $value->maq_pros_id;

                //suma
                $suma = carga::whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
                ->where('turno_id', '=', $tur->id)
                ->where(function($qm) use ($maq_id){
                    $qm ->whereNotNull('maq_pro_id')
                        -> where('maq_pro_id', '=', $maq_id);
                })
                ->orWhere(function($q) use ($proce_id){
                    $q -> whereNull('maq_pro_id')
                        ->where('proceso_id', '=', $proce_id);
                })
                ->sum('valor');

                //catidad
                $cuenta = carga::whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
                ->where('turno_id', '=', $tur->id)
                ->where(function($qm) use ($maq_id){
                    $qm ->whereNotNull('maq_pro_id')
                        -> where('maq_pro_id', '=', $maq_id);
                })
                ->orWhere(function($q) use ($proce_id){
                    $q -> whereNull('maq_pro_id')
                        ->where('proceso_id', '=', $proce_id);
                })
                ->count('valor');

                //resultado
                $fs += $suma;
                $fc += $cuenta;
                print( $val->nompro.' | '.$tur->nomtur.' | '.$fs.' | '.$fc.' / ');
            }
            //echo $tur;
        }
        echo 'Fin suma turno || ';
        return 'sm_t';
    }

    //operacion suma turno clave
    public function sm_tc($val, $dep, $fechas){
        //se consultan los turnos que existe menos el turno vacio
        $turnos = turnos::where('departamento_id', '=', $dep)
            ->where('nomtur', '!=', 'Vacío')
            ->get();
        //recorrido del turno
        foreach ($turnos as $tur) {
            //recorrido de formulas
            foreach ($val->formulas as $value) {
                $proce_id = $value->proceso_id;
                $maq_id = $value->maq_pros_id;
                //consulta
                $claves = carga::where('maq_pro_id', '=', $maq_id)
                    ->whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
                    ->with([
                        'clave' => function($cla){
                            $cla ->withTrashed()
                            -> select('id', 'CVE_ART', 'DESCR');
                        }
                    ])
                    ->distinct()
                    ->get(['clave_id']);
                //recorrido de claves
                foreach ($claves as $cl) {
                    //variablesde operaciones
                    $fs = 0;
                    $fc = 0;
                    //suma
                    $suma = carga::whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
                    ->where('clave_id', '=', $cl->clave_id)
                    ->where('turno_id', '=', $tur->id)
                    ->where(function($qm) use ($maq_id){
                        $qm ->whereNotNull('maq_pro_id')
                            -> where('maq_pro_id', '=', $maq_id);
                    })
                    ->orWhere(function($q) use ($proce_id){
                        $q -> whereNull('maq_pro_id')
                            ->where('proceso_id', '=', $proce_id);
                    })
                    ->sum('valor');

                    //catidad
                    $cuenta = carga::whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
                    ->where('turno_id', '=', $tur->id)
                    ->where('clave_id', '=', $cl->clave_id)
                    ->where(function($qm) use ($maq_id){
                        $qm ->whereNotNull('maq_pro_id')
                            -> where('maq_pro_id', '=', $maq_id);
                    })
                    ->orWhere(function($q) use ($proce_id){
                        $q -> whereNull('maq_pro_id')
                            ->where('proceso_id', '=', $proce_id);
                    })
                    ->count('valor');

                    //resultado
                    $fs += $suma;
                    $fc += $cuenta;
                    if ($fc != 0) {
                        print($val->nompro.' | '.$tur->nomtur.' | '.$cl->clave->CVE_ART.' | '.$fs.' | '.$fc.' - ');

                    }
                }
            }
        }
        echo 'fin de suma turno por clave';
        return 'sm_tc';
    }
}
