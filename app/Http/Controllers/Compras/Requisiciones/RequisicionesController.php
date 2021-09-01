<?php

namespace App\Http\Controllers\Compras\Requisiciones;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\Maquinas;
use App\Models\Compras\Requisiciones\ArticulosRequisiciones;
use App\Models\Compras\Requisiciones\Requisiciones;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use Illuminate\Http\Request;
use Inertia\Inertia;
class RequisicionesController extends Controller{

    public function index(){

        $Session = auth()->user();

        $Departamentos = Departamentos::orderBy('Nombre', 'asc')->get(['id','Nombre']);
        $Maquinas = Maquinas::get(['id','Nombre']);

        $ArticuloRequisicion = ArticulosRequisiciones::with([
            'ArticulosRequisicion' => function($req) { //Relacion 1 a 1 De puestos
                $req->select(
                    'id', 'IdUser',
                    'IdEmp', 'Folio',
                    'Fecha', 'NumReq',
                    'Departamento_id',
                    'jefes_areas_id',
                    'Codigo', 'Maquina_id',
                    'Marca_id', 'TipCompra',
                    'Observaciones', 'Estatus',
                    'OrdenCompra', 'Perfil_id');
            },
            'ArticulosRequisicion.RequisicionesPerfil' => function($perfil) { //Relacion 1 a 1 De puestos
                $perfil->select('id', 'Nombre', 'ApPat', 'ApMat');
            },
            'ArticulosRequisicion.RequisicionDepartamento' => function($departamento) { //Relacion 1 a 1 De puestos
                $departamento->select('id', 'Nombre');
            },
            'ArticulosRequisicion.RequisicionJefe' => function($jefe) { //Relacion 1 a 1 De puestos
                $jefe->select('id', 'Nombre');
            },
            'ArticulosRequisicion.RequisicionMaquina' => function($maquina) { //Relacion 1 a 1 De puestos
                $maquina->select('id', 'Nombre');
            },
            'ArticulosRequisicion.RequisicionMarca' => function($marca) { //Relacion 1 a 1 De puestos
                $marca->select('id', 'Nombre');
            },
        ])
        ->get(['id', 'Cantidad', 'Unidad', 'Descripcion', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'requisiciones_id']);

        return Inertia::render('Compras/Requisiciones/index', compact('Session', 'ArticuloRequisicion', 'Departamentos', 'Maquinas'));
    }

    public function create(){

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
