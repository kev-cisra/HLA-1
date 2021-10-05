<?php

namespace App\Http\Controllers\Produccion\Calculos;

use App\Http\Controllers\Controller;
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
                    ->whereBetween('fecha', )
                    ->get();

        return $hoy.' - '.$mañana;

        /* return redirect()->back()
            ->with('message', 'Post Created Successfully.'); */
    }
}
