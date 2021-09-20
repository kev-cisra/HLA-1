<?php

namespace App\Http\Controllers\Supply\Requisiciones;

use App\Http\Controllers\Controller;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GastosRequisiciones extends Controller{

    public function index(){
        $date = Carbon::now();
        $año = $date->format('Y');
        $mes = $date->format('m');
        $mesLetra = $date->format('M');

        $Session = auth()->user();
        $Departamentos = Departamentos::get();

        $GastoAño = (DB::select("
        SELECT SUM(Precio) AS Total FROM precios_cotizaciones
        WHERE YEAR(`created_at`) = ".$año."
        AND `Autorizado` = 2"));

        $GastoMes = (DB::select("
        SELECT SUM(Precio) AS Total FROM precios_cotizaciones
        WHERE MONTH(`created_at`) = ".$mes."
        AND `Autorizado` = 2"));

        $PresupuestoAño = (DB::select("
        SELECT SUM(Presupuesto) AS Total FROM presupuestos
        WHERE YEAR(`created_at`) = ".$año.""));

        $GastosApertura = (DB::select("
        SELECT SUM(P.Precio) AS Total FROM precios_cotizaciones AS P
        JOIN requisiciones AS R ON R.id = P.requisiciones_id
        WHERE MONTH(P.created_at) = '".$mes."'AND P.Autorizado = 2 AND R.Departamento_id = 7"));

        $PresupuestoApertura = (DB::select("
        SELECT SUM(Presupuesto) AS Total FROM presupuestos
        WHERE YEAR(`created_at`) = ".$año."
        AND Mes = '".$mesLetra."'
        AND `Departamento_id` = 7"));


        return Inertia::render('Supply/Presupuestos/GastosRequisiciones', compact(
            'Session', 'Departamentos',
            'GastoAño',
            'GastoMes',
            'PresupuestoAño',
            'GastosApertura',
            'PresupuestoApertura'
        ));
    }


    public function create(){
        //
    }

    public function store(Request $request){

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
