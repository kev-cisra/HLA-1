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
                    /* $this->sm_d($ope->formulas); */
                    break;
                case 'sm_dc':
                    /* $this->sm_dc($ope->formulas); */
                    break;
                case 'sm_t':
                    $this->sm_t($ope, $request->depa);
                    break;
            }
        }

        return 'Listo';

        /* return redirect()->back()
            ->with('message', 'Post Created Successfully.'); */
    }

    //operacion suma del dia
    public function sm_d($val){
        $fs = 0;
        $fc = 0;
        foreach ($val as $value) {
            $suma = carga::where('maq_pro_id', '=', $value->maq_pros_id)
            ->sum('valor');
            $cuenta = carga::where('maq_pro_id', '=', $value->maq_pros_id)
            ->count('valor');
            $fs += $suma;
            $fc += $cuenta;
            //print($fs.' | '.$cuenta.' / ');
        }

        echo $fs.' | '.$fc.'  fin suma dia || ';
        return 'sm_d';
    }

    //operacion suma dia clave
    public function sm_dc($val){
        foreach ($val as $value) {
            $claves = carga::where('maq_pro_id', '=', $value->maq_pros_id)
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
                $suma = carga::where('maq_pro_id', '=', $value->maq_pros_id)
                ->where('clave_id', '=', $cl->clave_id)
                ->sum('valor');
                $cuenta = carga::where('maq_pro_id', '=', $value->maq_pros_id)
                ->where('clave_id', '=', $cl->clave_id)
                ->count('valor');
                $fs += $suma;
                $fc += $cuenta;
                print($cl->clave->CVE_ART.' | '.$suma.' | '.$cuenta.' - ');
            }
        }
        echo ' fin suma clave dia || ';
        return 'sm_dc';

    }

    //operacion suma turno clave
    public function sm_t($val, $dep){
        $turnos = turnos::where('departamento_id', '=', 7)
            ->get();
        foreach ($turnos as $tur) {
            $fs = 0;
            $fc = 0;
            foreach ($val->formulas as $value) {
                $suma = carga::where('maq_pro_id', '=', $value->maq_pros_id)
                ->where('turno_id', '=', $tur->id)
                ->sum('valor');
                $cuenta = carga::where('maq_pro_id', '=', $value->maq_pros_id)
                ->where('turno_id', '=', $tur->id)
                ->count('valor');
                $fs += $suma;
                $fc += $cuenta;
                print($fs.' | '.$fc.' / ');
            }
            //echo $tur->nomtur.' | '.$fs.' | '.$fc.'  fin suma turnos || ';
        }
        return 'sm_t';
    }
}
