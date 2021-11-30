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

        $Session = auth()->user();
        $hoy = Carbon::now();
        //Obtencion de filtros para Fechas
        $request->month == '' ? $mes = $hoy->format('n') : $mes = $request->month;
        $anio = 2021;

        // 13844 13843 ->02  16668 4,2

        $Proveedores = Proveedores::get();

        $Perfiles = PerfilesUsuarios::where('jefes_areas_id', '=', $Session->id)->get();

        //Consulta Default filtrada por Mes
        if($mes != ''){
            //Consulta por Requisiciones con Filtro por mes
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
                    $pre->select('id', 'Precio', 'Total', 'Moneda', 'TipoCambio', 'Marca', 'Proveedor', 'Comentarios', 'Archivo', 'Firma', 'NombreProveedor', 'NumCotizacion', 'Autorizado', 'articulos_requisiciones_id', 'requisiciones_id');
                },
                ])
                ->whereYear('Fecha', $anio)
                ->whereMonth('Fecha', $mes)
                ->where('Estatus', '>', 4)
                ->get();


            //Consulta por articulos con filtro de Mes
            $ArticulosRequisiciones = ArticulosRequisiciones::with([
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
                'ArticuloPrecios' => function($pre) { //Relacion 1 a 1 De puestos
                    $pre->select('id', 'Precio', 'Total', 'Moneda', 'TipoCambio', 'Marca', 'Proveedor', 'Comentarios', 'Archivo', 'Autorizado', 'articulos_requisiciones_id', 'requisiciones_id');
                },
            ])
            ->whereMonth('Fecha', $mes)
            ->where('EstatusArt', '>', 4)
            ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id']);
        }

        //Consulta con Filtro de Estatus
        if ($request->Estatus != '') {
            //Consulta de requisiciones solo por Estatus
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
                    $pre->select('id', 'Precio', 'Total', 'Moneda', 'TipoCambio', 'Marca', 'Proveedor', 'Comentarios', 'Archivo', 'Firma', 'NombreProveedor', 'NumCotizacion', 'Autorizado', 'articulos_requisiciones_id', 'requisiciones_id');
                },
                ])
                ->whereYear('Fecha', $anio)
                ->where('Estatus', '>', 4)
                ->where('Estatus', $request->Estatus)
                ->get();

            //Consulta por articulos filtrado por Estatus
            $ArticulosRequisiciones = ArticulosRequisiciones::with([
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
                'ArticuloPrecios' => function($pre) { //Relacion 1 a 1 De puestos
                    $pre->select('id', 'Precio', 'Total', 'Moneda', 'TipoCambio', 'Marca', 'Proveedor', 'Comentarios', 'Archivo', 'Autorizado', 'articulos_requisiciones_id', 'requisiciones_id');
                },
            ])
            ->where('EstatusArt', '>', 4)
            ->where('EstatusArt', $request->Estatus)
            ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id']);

        }

        if($request->Req != ''){

            $Req = Requisiciones::where('id', '=', $request->Req)->get();
            // $ArticulosRequisiciones = ArticulosRequisiciones::where('requisicion_id','=', $request->Req)->get();
            $PreciosRequisicion = PreciosCotizaciones::where('requisiciones_id', '=', $request->Req)->get();
            //Obtengo el numero de cotizaciones realizadas para la requisicion
            $NumCot = PreciosCotizaciones::where('NumCotizacion', '=', 2)->where('requisiciones_id', '=', $request->Req)->count();

            //Consulta los articulos con sus precios correspondientes
            $ArticulosPrecios = ArticulosRequisiciones::with([
                'ArticuloPrecios' => function($pre) { //Relacion 1 a 1 De puestos
                    $pre->select('id', 'Precio', 'Total', 'Moneda', 'TipoCambio', 'Marca', 'Proveedor', 'Comentarios', 'Archivo', 'Autorizado', 'articulos_requisiciones_id', 'requisiciones_id');
                },
            ])
            ->where('requisicion_id', '=', $request->Req)
            ->get();


        }else{
            $Req = null;
            $PreciosRequisicion = null;
            $ArticulosPrecios = null;
            $NumCot = 0;
        }


        $Cotizacion = Requisiciones::whereBetween('Estatus', [3, 4])->count();

        $Pendientes = Requisiciones::where('Estatus', '=', 5)->count();

        $PendientesMes = Requisiciones::where('Estatus', '=', 5)->whereMonth('Fecha', $mes)->count();

        $Confirmar = Requisiciones::where('Estatus', '=', 6)->count();

        $CotizacionMes = Requisiciones::whereBetween('Estatus', [3, 4])->whereMonth('Fecha', $mes)->count();

        return Inertia::render('Supply/Requisiciones/Autoriza', compact(
            'Session',
            'Requisiciones',
            'ArticulosRequisiciones',
            'PreciosRequisicion',
            'ArticulosPrecios',
            'Req',
            'Proveedores',
            'Cotizacion',
            'Pendientes',
            'PendientesMes',
            'Confirmar',
            'CotizacionMes',
            'NumCot',
            'mes',
            ));
    }

    public function update(Request $request, $id){

        switch ($request->action){
            //Caso de autorizacion de precios de cotizacion 1
            case 1:

                //Genracion de Orden de Compra
                $MaxOrdenCompra = Requisiciones::max('OrdenCompra');

                if($MaxOrdenCompra >= 1000){
                    $OrdenCompra = $MaxOrdenCompra + 1;
                }else{
                    $OrdenCompra = 1000;
                }

                Requisiciones::where('id', '=', $request->requisicion_id)->update([
                    'Estatus' => 6,
                    'OrdenCompra' => $OrdenCompra,
                ]);

                ArticulosRequisiciones::where('requisicion_id', '=', $request->requisicion_id)->where('EstatusArt', '=', 5)->update([
                    'EstatusArt' => 6,
                ]);

                //Metodos de autorizacion
                PreciosCotizaciones::where('requisiciones_id', '=', $request->requisicion_id)->where('NumCotizacion', '=', 1)
                ->update([
                    'Autorizado' => 2, //Estatus 2 Autorizado
                ]); //Se autoriza los que tengan estatus 2

                PreciosCotizaciones::where('requisiciones_id', '=', $request->requisicion_id)->where('NumCotizacion', '!=', 1)
                ->update([
                    'Autorizado' => 1, //Estatus 1 Rechazado
                ]); //Rechazo los precios de la cotizacion 2

                TiemposRequisiciones::where('articulo_requisicion_id', '=', $request->id)->update([
                    'Autorizado' => Carbon::now(),
                ]);

                break;
            // Caso de mas de una cotizacion, Se autoriza la segunda cotizacion
            case 2:
                //Genracion de Orden de Compra
                $MaxOrdenCompra = Requisiciones::max('OrdenCompra');

                if($MaxOrdenCompra >= 1000){
                    $OrdenCompra = $MaxOrdenCompra + 1;
                }else{
                    $OrdenCompra = 1000;
                }

                //Actulizaciones de Estatus
                Requisiciones::where('id', '=', $request->requisicion_id)->update([
                    'Estatus' => 6,
                    'OrdenCompra' => $OrdenCompra,
                ]);

                ArticulosRequisiciones::where('requisicion_id', '=', $request->requisicion_id)->where('EstatusArt', '=', 5)->update([
                    'EstatusArt' => 6,
                ]);

                //Metodos de autorizacion
                PreciosCotizaciones::where('requisiciones_id', '=', $request->requisicion_id)->where('NumCotizacion', '=', 2)
                ->update([
                    'Autorizado' => 2, //Estatus 2 Autorizado
                ]); //Se autoriza los que tengan estatus 2

                PreciosCotizaciones::where('requisiciones_id', '=', $request->requisicion_id)->where('NumCotizacion', '!=', 2)
                ->update([
                    'Autorizado' => 1, //Estatus 1 Rechazado
                ]); //Rechazo los precios de la cotizacion 2

                TiemposRequisiciones::where('articulo_requisicion_id', '=', $request->id)->update([
                    'Autorizado' => Carbon::now(),
                ]);

                break;
        }

        return redirect()->back();
    }
}
