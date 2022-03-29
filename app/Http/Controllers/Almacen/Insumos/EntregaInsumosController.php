<?php

namespace App\Http\Controllers\Almacen\Insumos;

use App\Http\Controllers\Controller;
use App\Models\Compras\Insumos\Insumos;
use App\Models\Compras\Insumos\RequisicionesInsumos;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use stdClass;

class EntregaInsumosController extends Controller{

    public function index(Request $request){
        $Session = auth()->user();
        $User = User::find($Session->id); //Accedo a los datos del usuario logueado
        $Autorizado = $User->hasAnyRole(['ONEPIECE', 'ADMINISTRADOR', 'SISTEMAS', 'SUPPLY']); //Busco si el suaurio tiene alguno de los siguientes Roles

        if($Autorizado == true){ //Usuario Admin
            //Catalogos
            $Departamentos = Departamentos::whereIn('id', [8, 12, 13, 23, 25])->get(['id', 'Nombre']);
            $Insumos = Insumos::get();

            //Consulta Principal
            $RequisicionesInsumos = RequisicionesInsumos::with([
                'Perfil' => function($Perfil) { //Relacion 1 a 1 De puestos
                    $Perfil->select('id', 'Nombre', 'ApPat', 'ApMat');
                },
                'Departamento' => function($Departamento) { //Relacion 1 a 1 De puestos
                    $Departamento->select('id', 'Nombre');
                },
                'Articulos' => function($Articulos) { //Relacion 1 a 1 De puestos
                    $Articulos->select('id', 'IdUser', 'Cantidad', 'Estatus', 'insumo_id', 'requisiciones_insumos_id');
                },
                'Articulos.Insumo' => function($Articulos) { //Relacion 1 a 1 De puestos
                    $Articulos->select('id', 'IdUser', 'Clave', 'Nombre', 'Linea', 'Unidad');
                }
            ])->get();
        }else{
            //Catalogos
            $Departamentos = Departamentos::whereIn('id', [8, 12, 13, 23, 25])->get(['id', 'Nombre']);
            $Insumos = Insumos::get();
            //Obtengo el id del perfil
            $Perfil = PerfilesUsuarios::where('user_id', '=', $Session->id)->first('id');

            //Consulta Principal
            $RequisicionesInsumos = RequisicionesInsumos::with([
                'Perfil' => function($Perfil) { //Relacion 1 a 1 De puestos
                    $Perfil->select('id', 'Nombre', 'ApPat', 'ApMat');
                },
                'Departamento' => function($Departamento) { //Relacion 1 a 1 De puestos
                    $Departamento->select('id', 'Nombre');
                },
                'Articulos' => function($Articulos) { //Relacion 1 a 1 De puestos
                    $Articulos->select('id', 'IdUser', 'Cantidad', 'Estatus', 'insumo_id', 'requisiciones_insumos_id');
                },
                'Articulos.Insumo' => function($Articulos) { //Relacion 1 a 1 De puestos
                    $Articulos->select('id', 'IdUser', 'Clave', 'Nombre', 'Linea', 'Unidad');
                }
            ])->where('Perfil_id', '=',$Perfil->id)
            ->get();
        }

        if($request->Req){

            $RequisicionInsumo = RequisicionesInsumos::with([
                'Perfil' => function($Perfil) { //Relacion 1 a 1 De puestos
                    $Perfil->select('id', 'Nombre', 'ApPat', 'ApMat');
                },
                'Departamento' => function($Departamento) { //Relacion 1 a 1 De puestos
                    $Departamento->select('id', 'Nombre');
                },
                'Articulos' => function($Articulos) { //Relacion 1 a 1 De puestos
                    $Articulos->select('id', 'IdUser', 'Cantidad', 'Estatus', 'insumo_id', 'requisiciones_insumos_id');
                },
                'Articulos.Insumo' => function($Articulos) { //Relacion 1 a 1 De puestos
                    $Articulos->select('id', 'IdUser', 'Clave', 'Nombre', 'Linea', 'Unidad');
                }
            ])->where('id', '=', $request->Req)->first();

        }else{
            $RequisicionInsumo = new stdClass();
        }

        return Inertia::render('Almacen/Insumos/', compact('Session', 'Departamentos', 'Insumos', 'RequisicionesInsumos', 'RequisicionInsumo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
