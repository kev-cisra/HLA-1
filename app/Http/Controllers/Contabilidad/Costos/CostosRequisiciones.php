<?php

namespace App\Http\Controllers\Contabilidad\Costos;

use App\Http\Controllers\Controller;
use App\Models\Compras\Requisiciones\PreciosCotizaciones;
use App\Models\Compras\Requisiciones\Requisiciones;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\QueryBuilder;

class CostosRequisiciones extends Controller{

    public function index(Request $request){

        $hoy = Carbon::now();

        //Asigno el mes actual o uno recibido por request
        $request->Year == '' ? $anio = $hoy->format('Y') : $anio = $request->Year;
        $request->Month == '' ? $mes = $hoy->format('n') : $mes = $request->Month;
        $request->Dpto == 0 ? $dpto = 0 : $dpto = $request->Dpto;

        $Departamentos = Departamentos::where('departamento_id', '=', 2)->get(['id', 'Nombre']);

        if($mes != 0 && $dpto == 0){ //Consulta Inicial (Mes especifico con todos los departamentos)
            $PreciosRequisiciones = PreciosCotizaciones::with([
                'PrecioProveedor' => function($prov) { //Relacion 1 a 1 De puestos
                    $prov->select('id', 'Nombre');
                },
                'PreciosArticulo' => function($articulo) { //Relacion 1 a 1 De puestos
                    $articulo->select('id', 'Fecha', 'IdEmp', 'Cantidad', 'Unidad', 'Descripcion', 'requisicion_id');
                },
                'PreciosArticulo.ArticulosRequisicion' => function($requisicion) { //Relacion 1 a 1 De puestos
                    $requisicion->select('id', 'Fecha', 'NumReq', 'OrdenCompra', 'Departamento_id', 'jefes_areas_id', 'Maquina_id', 'Marca_id', 'TipCompra', 'Estatus');
                },
                'PreciosArticulo.ArticulosRequisicion.RequisicionDepartamento' => function($departamento) { //Relacion 1 a 1 De puestos
                    $departamento->select('id', 'Nombre');
                },
                'PreciosArticulo.ArticulosRequisicion.RequisicionMaquina' => function($Maquina) { //Relacion 1 a 1 De puestos
                    $Maquina->select('id', 'Nombre');
                },
            ])->whereHas('PreciosArticulo.ArticulosRequisicion', function($query) use($anio, $mes, $dpto){
                $query->where('Estatus', '>=', 6);
                $query->whereYear('Fecha', '=', $anio);
                $query->whereMonth('Fecha', '=', $mes);
            })->get();
        }elseif ($mes == 0 && $dpto == 0) { //Informacion de todo el año
            $PreciosRequisiciones = PreciosCotizaciones::with([
                'PrecioProveedor' => function($prov) { //Relacion 1 a 1 De puestos
                    $prov->select('id', 'Nombre');
                },
                'PreciosArticulo' => function($articulo) { //Relacion 1 a 1 De puestos
                    $articulo->select('id', 'Fecha', 'IdEmp', 'Cantidad', 'Unidad', 'Descripcion', 'requisicion_id');
                },
                'PreciosArticulo.ArticulosRequisicion' => function($requisicion) { //Relacion 1 a 1 De puestos
                    $requisicion->select('id', 'Fecha', 'NumReq', 'OrdenCompra', 'Departamento_id', 'jefes_areas_id', 'Maquina_id', 'Marca_id', 'TipCompra', 'Estatus');
                },
                'PreciosArticulo.ArticulosRequisicion.RequisicionDepartamento' => function($departamento) { //Relacion 1 a 1 De puestos
                    $departamento->select('id', 'Nombre');
                },
                'PreciosArticulo.ArticulosRequisicion.RequisicionMaquina' => function($Maquina) { //Relacion 1 a 1 De puestos
                    $Maquina->select('id', 'Nombre');
                },
            ])->whereHas('PreciosArticulo.ArticulosRequisicion', function($query) use($anio, $mes, $dpto){
                $query->where('Estatus', '>=', 6);
                $query->whereYear('Fecha', '=', $anio);
            })->get();
        }elseif($mes == 0 && $dpto != 0) { //Departamento especifico
            $PreciosRequisiciones = PreciosCotizaciones::with([
                'PrecioProveedor' => function($prov) { //Relacion 1 a 1 De puestos
                    $prov->select('id', 'Nombre');
                },
                'PreciosArticulo' => function($articulo) { //Relacion 1 a 1 De puestos
                    $articulo->select('id', 'Fecha', 'IdEmp', 'Cantidad', 'Unidad', 'Descripcion', 'requisicion_id');
                },
                'PreciosArticulo.ArticulosRequisicion' => function($requisicion) { //Relacion 1 a 1 De puestos
                    $requisicion->select('id', 'Fecha', 'NumReq', 'OrdenCompra', 'Departamento_id', 'jefes_areas_id', 'Maquina_id', 'Marca_id', 'TipCompra', 'Estatus');
                },
                'PreciosArticulo.ArticulosRequisicion.RequisicionDepartamento' => function($departamento) { //Relacion 1 a 1 De puestos
                    $departamento->select('id', 'Nombre');
                },
                'PreciosArticulo.ArticulosRequisicion.RequisicionMaquina' => function($Maquina) { //Relacion 1 a 1 De puestos
                    $Maquina->select('id', 'Nombre');
                },
            ])->whereHas('PreciosArticulo.ArticulosRequisicion', function($query) use($anio, $mes, $dpto){
                $query->where('Estatus', '>=', 6);
                $query->whereYear('Fecha', '=', $anio);
                $query->where('Departamento_id', '=', $dpto);
            })->get();
        }elseif ($mes != 0 && $dpto != 0) {
            $PreciosRequisiciones = PreciosCotizaciones::with([
                'PrecioProveedor' => function($prov) { //Relacion 1 a 1 De puestos
                    $prov->select('id', 'Nombre');
                },
                'PreciosArticulo' => function($articulo) { //Relacion 1 a 1 De puestos
                    $articulo->select('id', 'Fecha', 'IdEmp', 'Cantidad', 'Unidad', 'Descripcion', 'requisicion_id');
                },
                'PreciosArticulo.ArticulosRequisicion' => function($requisicion) { //Relacion 1 a 1 De puestos
                    $requisicion->select('id', 'Fecha', 'NumReq', 'OrdenCompra', 'Departamento_id', 'jefes_areas_id', 'Maquina_id', 'Marca_id', 'TipCompra', 'Estatus');
                },
                'PreciosArticulo.ArticulosRequisicion.RequisicionDepartamento' => function($departamento) { //Relacion 1 a 1 De puestos
                    $departamento->select('id', 'Nombre');
                },
                'PreciosArticulo.ArticulosRequisicion.RequisicionMaquina' => function($Maquina) { //Relacion 1 a 1 De puestos
                    $Maquina->select('id', 'Nombre');
                },
            ])->whereHas('PreciosArticulo.ArticulosRequisicion', function($query) use($anio, $mes, $dpto){
                $query->where('Estatus', '>=', 6);
                $query->whereYear('Fecha', '=', $anio);
                $query->whereMonth('Fecha', '=', $mes);
                $query->where('Departamento_id', '=', $dpto);
            })->get();
        }

        return Inertia::render('Contabilidad/Costos/CostosRequisiciones', compact('Departamentos', 'PreciosRequisiciones', 'anio', 'mes'));
    }

}
