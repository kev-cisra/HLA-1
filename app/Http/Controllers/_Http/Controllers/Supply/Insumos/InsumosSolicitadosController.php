<?php

namespace App\Http\Controllers\Supply\Insumos;

use App\Http\Controllers\Controller;
use App\Models\Compras\Insumos\Insumos;
use App\Models\Compras\Insumos\RequisicionInsumos;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class InsumosSolicitadosController extends Controller{

    public function index(Request $request){

        $Session = auth()->user();

        $hoy = Carbon::now();

        $request->month == '' ? $mes = $hoy->format('n') : $mes = $request->month;

        $Insumos = Insumos::where('Departamento_id', '=', 7)->get(['id', 'IdUser', 'Nombre', 'Unidad', 'Departamento_id']);

        $NumInsumos = Insumos::where('Departamento_id', '=', 7)->count();

        $ReqInsumos = RequisicionInsumos::with([
            'RequisicionesInsumosMaterial' => function($req) { //Relacion 1 a 1 De puestos
                $req->select(
                    'id', 'IdUser', 'Nombre','Unidad','Departamento_id');
            },
            'RequisicionesInsumosPerfil' => function($perfil) { //Relacion 1 a 1 De puestos
                $perfil->select('id', 'IdUser', 'IdEmp','Nombre', 'ApPat', 'ApMat');
            },
            'RequisicionInsumosDepartamento' => function($perfil) { //Relacion 1 a 1 De puestos
                $perfil->select('id', 'IdUser', 'Nombre', 'departamento_id');
            }
        ])
        ->whereMonth('created_at', $mes)
        ->get(['id', 'IdUser', 'IdEmp', 'Departamento_id', 'Insumo_id', 'Cantidad', 'Estatus']);

        return Inertia::render('Supply/Insumos/InsumosSolicitados', compact('Session', 'mes', 'Insumos', 'NumInsumos', 'ReqInsumos'));
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
