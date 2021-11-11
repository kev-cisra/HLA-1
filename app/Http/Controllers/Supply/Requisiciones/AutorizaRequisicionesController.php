<?php

namespace App\Http\Controllers\Supply\Requisiciones;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\Maquinas;
use App\Models\Compras\Proveedores;
use App\Models\Compras\Requisiciones\ArticulosRequisiciones;
use App\Models\Compras\Requisiciones\PreciosCotizaciones;
use App\Models\Compras\Requisiciones\Requisiciones;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Catalogos\JefesArea;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use App\Models\Supply\Requisiciones\TiemposRequisiciones;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AutorizaRequisicionesController extends Controller{

    public function index(Request $request){

        $hoy = Carbon::now();

        $request->month == '' ? $mes = $hoy->format('n') : $mes = $request->month;

        $Session = auth()->user();

        //Consulta pra obtener el id de Jefe de acuerdo al numero de empleado del trabajador
        $ObtenJefe = JefesArea::where('IdEmp', '=', $Session->IdEmp)->first(['id','IdEmp']);
        if(isset($ObtenJefe)){
            $IdJefe = $ObtenJefe->id; //Obtengo el id de trabajador de acuerdo al idEmpleado de la session

            //Consulta para obtener los datos de los trabajadores pertenecientes al id de la session
            $PerfilesUsuarios = PerfilesUsuarios::where('jefes_areas_id', '=', $IdJefe)->get();
        }else{
            $PerfilesUsuarios = PerfilesUsuarios::get();
        }

        $Proveedores = Proveedores::get();

        $Perfiles = PerfilesUsuarios::where('jefes_areas_id', '=', $Session->id)->get();

        if($request->Estatus == ''){

            $ArticuloRequisicion = ArticulosRequisiciones::with([
                'ArticulosRequisicion' => function($req) { //Relacion 1 a 1 De puestos
                    $req->select(
                        'id', 'IdUser',
                        'IdEmp', 'Folio',
                        'NumReq',
                        'Departamento_id',
                        'jefes_areas_id',
                        'Codigo', 'Maquina_id',
                        'Marca_id', 'TipCompra',
                        'Observaciones', 'Perfil_id');
                },
                'ArticuloPrecios' => function($pre) { //Relacion 1 a 1 De puestos
                    $pre->select('id', 'Precio', 'Total', 'Moneda', 'TipoCambio', 'Marca', 'Proveedor', 'Comentarios', 'Archivo', 'Autorizado', 'articulos_requisiciones_id', 'requisiciones_id');
                },
                'ArticuloUser' => function($perfil) { //Relacion 1 a 1 De puestos
                    $perfil->select('id', 'name');
                },
                'ArticulosRequisicion.RequisicionesPerfil' => function($perfil) { //Relacion 1 a 1 De puestos
                    $perfil->select('id', 'Nombre', 'ApPat', 'ApMat', 'jefes_areas_id');
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
            ->orderBy('EstatusArt', 'asc')
            ->where('EstatusArt', '>=', 5)
            ->whereMonth('Fecha', $mes)
            ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'OrdenCompra', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'requisicion_id']);

        }elseif($request->Estatus != '' && $request->month != ''){

            $ArticuloRequisicion = ArticulosRequisiciones::with([
                'ArticulosRequisicion' => function($req) { //Relacion 1 a 1 De puestos
                    $req->select(
                        'id', 'IdUser',
                        'IdEmp', 'Folio',
                        'NumReq',
                        'Departamento_id',
                        'jefes_areas_id',
                        'Codigo', 'Maquina_id',
                        'Marca_id', 'TipCompra',
                        'Observaciones', 'Perfil_id');
                },
                'ArticuloPrecios' => function($pre) { //Relacion 1 a 1 De puestos
                    $pre->select('id', 'Precio', 'Total', 'Moneda', 'TipoCambio', 'Marca', 'Proveedor', 'Comentarios', 'Archivo', 'Autorizado', 'articulos_requisiciones_id', 'requisiciones_id');
                },
                'ArticulosRequisicion.RequisicionesPerfil' => function($perfil) { //Relacion 1 a 1 De puestos
                    $perfil->select('id', 'Nombre', 'ApPat', 'ApMat', 'jefes_areas_id');
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
            ->orderBy('EstatusArt', 'asc')
            ->where('EstatusArt', '>=', 5)
            ->where('EstatusArt', $request->Estatus)
            ->whereMonth('Fecha', $mes)
            ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'OrdenCompra', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'requisicion_id']);

        }else{

            $ArticuloRequisicion = ArticulosRequisiciones::with([
                'ArticulosRequisicion' => function($req) { //Relacion 1 a 1 De puestos
                    $req->select(
                        'id', 'IdUser',
                        'IdEmp', 'Folio',
                        'NumReq',
                        'Departamento_id',
                        'jefes_areas_id',
                        'Codigo', 'Maquina_id',
                        'Marca_id', 'TipCompra',
                        'Observaciones', 'Perfil_id');
                },
                'ArticuloPrecios' => function($pre) { //Relacion 1 a 1 De puestos
                    $pre->select('id', 'Precio', 'Total', 'Moneda', 'TipoCambio', 'Marca', 'Proveedor', 'Comentarios', 'Archivo', 'Autorizado', 'articulos_requisiciones_id', 'requisiciones_id');
                },
                'ArticulosRequisicion.RequisicionesPerfil' => function($perfil) { //Relacion 1 a 1 De puestos
                    $perfil->select('id', 'Nombre', 'ApPat', 'ApMat', 'jefes_areas_id');
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
            ->orderBy('EstatusArt', 'asc')
            ->where('EstatusArt', '>=', 5)
            ->where('EstatusArt', $request->Estatus)
            ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'OrdenCompra', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'requisicion_id']);
        }

        if($request->Cot != ''){
            $PreciosCotizacion = PreciosCotizaciones::with('PreciosArticulo')->where('articulos_requisiciones_id','=', $request->Cot)->get();
        }else{
            $PreciosCotizacion = PreciosCotizaciones::with('PreciosArticulo')->get();
        }

        $Requisiciones = Requisiciones::with([
            'RequisicionesPerfil' => function($perfil) {
                $perfil->select('id', 'Nombre', 'ApPat', 'ApMat', 'jefes_areas_id');
            },
            'RequisicionDepartamento' => function($departamento) {
                $departamento->select('id', 'Nombre');
            },
            'RequisicionJefe' => function($jefe) {
                $jefe->select('id', 'Nombre');
            },
            'RequisicionMaquina' => function($maquina) {
                $maquina->select('id', 'Nombre');
            },
            'RequisicionMarca' => function($marca) {
                $marca->select('id', 'Nombre');
            },
            'RequisicionArticulos' => function($Req) {
                $Req->select('id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'OrdenCompra', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'requisicion_id');
            },
            'RequisicionArticulos.ArticuloPrecios' => function($pre) {
                $pre->select('id', 'Precio', 'Total', 'Moneda', 'TipoCambio', 'Marca', 'Proveedor', 'Comentarios', 'Archivo', 'Autorizado', 'articulos_requisiciones_id', 'requisiciones_id');
            },
            ])
            ->where('Estatus', '>=', 5)
            ->get();

            if($request->Req != ''){

            $Articulos = ArticulosRequisiciones::with([
                'ArticuloPrecios' => function($pre) { //Relacion 1 a 1 De puestos
                    $pre->select('id', 'Precio', 'Total', 'Moneda', 'TipoCambio', 'Marca', 'Proveedor', 'Comentarios', 'Archivo', 'Autorizado', 'articulos_requisiciones_id', 'requisiciones_id');
                },
            ])
            ->where('requisicion_id', '=', $request->Req)
            ->get();

            $ArtCount = ArticulosRequisiciones::where('requisicion_id', '=', $request->Req)->count();
            $PreCount = PreciosCotizaciones::where('requisiciones_id', '=', $request->Req)->count();

            $NumCotizaciones = $PreCount/$ArtCount;

            $PreciosRequisicion = Requisiciones::with([
                'RequisicionesPerfil' => function($perfil) {
                    $perfil->select('id', 'Nombre', 'ApPat', 'ApMat', 'jefes_areas_id');
                },
                'RequisicionDepartamento' => function($departamento) {
                    $departamento->select('id', 'Nombre');
                },
                'RequisicionJefe' => function($jefe) {
                    $jefe->select('id', 'Nombre');
                },
                'RequisicionMaquina' => function($maquina) {
                    $maquina->select('id', 'Nombre');
                },
                'RequisicionMarca' => function($marca) {
                    $marca->select('id', 'Nombre');
                },
                'RequisicionArticulos' => function($Req) {
                    $Req->select('id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'OrdenCompra', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'requisicion_id');
                },
                'RequisicionArticulos.ArticuloPrecios' => function($pre) {
                    $pre->select('id', 'Precio', 'Total', 'Moneda', 'TipoCambio', 'Marca', 'Proveedor', 'Comentarios', 'Archivo', 'Autorizado', 'articulos_requisiciones_id', 'requisiciones_id');
                },
                ])
                ->where('Estatus', '>=', 5)
                ->where('id', '=', $request->Req)
                ->get();

        }else{
            $Articulos = null;
            $PreciosRequisicion = null;
            $PreCount = null;
            $NumCotizaciones = null;
        }


        $Cotizacion = ArticulosRequisiciones::whereBetween('EstatusArt', [3, 4])->count();

        $Pendientes = ArticulosRequisiciones::where('EstatusArt', '=', 5)->count();

        $PendientesMes = ArticulosRequisiciones::where('EstatusArt', '=', 5)->whereMonth('Fecha', $mes)->count();

        $Confirmar = ArticulosRequisiciones::where('EstatusArt', '=', 6)->count();

        $CotizacionMes = ArticulosRequisiciones::whereBetween('EstatusArt', [3, 4])->whereMonth('Fecha', $mes)->count();

        return Inertia::render('Supply/Requisiciones/Autoriza', compact(
            'Session',
            'PerfilesUsuarios',
            'ArticuloRequisicion',
            'PreciosCotizacion',
            'Proveedores',
            'Cotizacion',
            'Pendientes',
            'PendientesMes',
            'Confirmar',
            'CotizacionMes',
            'mes',
            'Requisiciones',
            'Articulos',
            'PreciosRequisicion',
            'NumCotizaciones',
            ));
    }

    public function update(Request $request, $id){

        switch ($request->action){
            case 1:
                Requisiciones::where('id', '=', $request->requisicion_id)->update([
                    'Estatus' => 6,
                ]);

                ArticulosRequisiciones::where('requisicion_id', '=', $request->requisicion_id)->update([
                    'EstatusArt' => 6,
                ]);

                PreciosCotizaciones::where('requisiciones_id', '=', $request->requisicion_id)->update([
                    'Autorizado' => 2,
                ]);

                TiemposRequisiciones::where('articulo_requisicion_id', '=', $request->id)->update([
                    'Autorizado' => Carbon::now(),
                ]);

                break;

            case 2:

                Requisiciones::where('id', '=', $request->requisicion_id)->update([
                    'Estatus' => 6,
                ]);

                ArticulosRequisiciones::where('requisicion_id', '=', $request->requisicion_id)->update([
                    'EstatusArt' => 6,
                ]);

                PreciosCotizaciones::where('requisiciones_id', '=', $request->requisicion_id)->where('NumCotizacion', '=', $request->action)
                ->update([
                    'Autorizado' => 2,
                ]);

                PreciosCotizaciones::where('requisiciones_id', '=', $request->requisicion_id)->where('NumCotizacion', '=', 1)
                ->update([
                    'Autorizado' => 1,
                ]);

                TiemposRequisiciones::where('articulo_requisicion_id', '=', $request->id)->update([
                    'Autorizado' => Carbon::now(),
                ]);

                break;
        }

        return redirect()->back();
    }
}
