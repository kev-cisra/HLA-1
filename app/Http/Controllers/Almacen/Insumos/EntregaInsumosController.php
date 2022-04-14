<?php

namespace App\Http\Controllers\Almacen\Insumos;

use App\Http\Controllers\Controller;
use App\Models\Compras\Insumos\ArticulosRequisicionesInsumos;
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
        ])->where('Estatus', '>', 1)
        ->get();

        if($request->Req){ //Consulta individual
            $ArticulosReq = ArticulosRequisicionesInsumos::with([
                'Insumo' => function($Articulos) { //Relacion 1 a 1 De puestos
                    $Articulos->select('id', 'IdUser', 'Clave', 'Nombre', 'Linea', 'Unidad');
                }
            ])->where('requisiciones_insumos_id', '=', $request->Req)->get();

        }else{
            $ArticulosReq = new stdClass();
        }

        return Inertia::render('Almacen/Insumos/EntregasInsumos', compact('Session', 'RequisicionesInsumos', 'ArticulosReq'));
    }

    public function update(Request $request, $id){

        switch ($request->Metodo) {

            case 1: //Caso de entregar producto
                ArticulosRequisicionesInsumos::where('id', '=', $request->id)->update([
                    'Estatus' => 3,
                ]);
                //Actualizao el estauts
                $Articulos = ArticulosRequisicionesInsumos::where('requisiciones_insumos_id', $request->requisiciones_insumos_id)
                ->where('Estatus', '=', 2)->count();
                //Actualizo el estauts de la requisicion si todos los productos fueron entregados
                if($Articulos == 0){
                    RequisicionesInsumos::where('id', $request->requisiciones_insumos_id)->update([
                        'Estatus' => 4, //Requisicion Entregada completamente
                    ]);
                }else{
                    RequisicionesInsumos::where('id', $request->requisiciones_insumos_id)->update([
                        'Estatus' => 3, //Requisicion Parcial
                    ]);
                }
                return redirect()->back();
                break;

            case 2: //Parcialidad de partida

                $Session = auth()->user();
                //Actualizo la cantidad de la partida
                ArticulosRequisicionesInsumos::where('id', '=', $request->id)->update([
                    'Cantidad' => $request->CantidadParcial,
                ]);
                //Creo unanueva partida con la cantidad faltante
                ArticulosRequisicionesInsumos::create([
                    'IdUser' => $Session->id,
                    'Cantidad' => $request->CantidadRestante,
                    'Estatus' => 2,
                    'requisiciones_insumos_id' => $request->requisiciones_insumos_id,
                    'insumo_id' => $request->insumo_id,
                ]);

                return redirect()->back();
                break;
        }
    }

    public function destroy($id){

    }
}
