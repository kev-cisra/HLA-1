<?php

namespace App\Http\Controllers\Produccion\Calculos;

use App\Http\Controllers\Controller;
use App\Models\Produccion\carga;
use App\Models\Produccion\catalogos\procesos;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
                    $this->sm_d($ope->formulas);
                    break;

                default:
                    # code...
                    break;
            }
        }

        return '$calcula';

        /* return redirect()->back()
            ->with('message', 'Post Created Successfully.'); */
    }

    //operacion suma del dia
    public function sm_d($val){
        $fs = 0;
        $fc = 0;
        foreach ($val as $value) {
            # code...
            $suma = carga::where('maq_pro_id', '=', $value->maq_pros_id)
            ->sum('valor');
            $cuenta = carga::where('maq_pro_id', '=', $value->maq_pros_id)
            ->count('valor');
            $fs += $suma;
            $fc += $cuenta;
            //print($fs.' | '.$cuenta.' / ');
        }

        echo $fs.' | '.$fc.'  FIN SUMA DIA ';
        return '';
    }
}
