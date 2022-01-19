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
use App\Mail\ContactaProveedorMailable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

class AutorizaRequisicionesController extends Controller{

    public function index(Request $request){

        $Session = auth()->user();
        $hoy = Carbon::now();

        //Obtencion de filtros para Fechas
        $request->Month == '' ? $mes = $hoy->format('n') : $mes = $request->Month;
        $request->Year == '' ? $anio = $hoy->format('Y') : $anio = $request->Year;
        $request->View == '' ? $Vista = 1 : $Vista = $request->View;

        //Catalogo de Proveedores
        $Proveedores = Proveedores::get();

        //Indicadores
        $Cotizacion = Requisiciones::whereBetween('Estatus', [3, 4])->count();
        $Pendientes = Requisiciones::where('Estatus', '=', 5)->count();
        $PendientesMes = Requisiciones::where('Estatus', '=', 5)->whereYear('Fecha', $anio)->whereMonth('Fecha', $mes)->count();
        $Confirmar = Requisiciones::where('Estatus', '=', 6)->count();
        $ICotizacionMes = Requisiciones::whereBetween('Estatus', [3, 4])->whereMonth('Fecha', $mes)->count();

        /* *********************************** CONSULTA PRINCIPAL ********************************* */
        if($Vista == 1){

            $Requisiciones = ArticulosRequisiciones::with([
                'ArticulosRequisicion' => function($req) { //Relacion 1 a 1 De puestos
                    $req->select(
                        'id', 'IdUser', 'Fecha',
                        'IdEmp', 'Folio',
                        'NumReq', 'OrdenCompra',
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
            ])
            ->where('EstatusArt', '>', 4)
            ->whereYear('Fecha', $anio)
            ->whereMonth('Fecha', $mes)
            ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'MotivoRechazo','Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id']);

            if($request->Year == 0 && $request->Month == 0 && $request->Status == 0){

                $Requisiciones = ArticulosRequisiciones::with([
                    'ArticulosRequisicion' => function($req) { //Relacion 1 a 1 De puestos
                        $req->select(
                            'id', 'IdUser', 'Fecha',
                            'IdEmp', 'Folio',
                            'NumReq', 'OrdenCompra',
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
                ])
                ->where('EstatusArt', '>', 4)
                ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'MotivoRechazo','Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id']);

            }elseif ($request->Year == 0 && $request->Month != 0 && $request->Status == 0) {

                $Requisiciones = ArticulosRequisiciones::with([
                    'ArticulosRequisicion' => function($req) { //Relacion 1 a 1 De puestos
                        $req->select(
                            'id', 'IdUser', 'Fecha',
                            'IdEmp', 'Folio',
                            'NumReq', 'OrdenCompra',
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
                ])
                ->whereMonth('Fecha', $mes)
                ->where('EstatusArt', '>', 4)
                ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'MotivoRechazo','Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id']);

            }elseif ($request->Year == 0 && $request->Month == 0 && $request->Status != 0){

                $Requisiciones = ArticulosRequisiciones::with([
                    'ArticulosRequisicion' => function($req) { //Relacion 1 a 1 De puestos
                        $req->select(
                            'id', 'IdUser', 'Fecha',
                            'IdEmp', 'Folio',
                            'NumReq', 'OrdenCompra',
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
                ])
                ->where('EstatusArt', '=', $request->Status)
                ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'MotivoRechazo','Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id']);

            }elseif ($request->Year == 0 && $request->Month != 0 && $request->Status != 0){

                $Requisiciones = ArticulosRequisiciones::with([
                    'ArticulosRequisicion' => function($req) { //Relacion 1 a 1 De puestos
                        $req->select(
                            'id', 'IdUser', 'Fecha',
                            'IdEmp', 'Folio',
                            'NumReq', 'OrdenCompra',
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
                ])
                ->whereMonth('Fecha', $mes)
                ->where('EstatusArt', '=', $request->Status)
                ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'MotivoRechazo','Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id']);

            }elseif ($request->Year != 0 && $request->Month == 0 && $request->Status != 0){
                $Requisiciones = ArticulosRequisiciones::with([
                    'ArticulosRequisicion' => function($req) { //Relacion 1 a 1 De puestos
                        $req->select(
                            'id', 'IdUser', 'Fecha',
                            'IdEmp', 'Folio',
                            'NumReq', 'OrdenCompra',
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
                ])
                ->whereYear('Fecha', $anio)
                ->where('EstatusArt', '=', $request->Status)
                ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'MotivoRechazo','Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id']);
            }elseif ($request->Year != 0 && $request->Month != 0 && $request->Status != 0){
                $Requisiciones = ArticulosRequisiciones::with([
                    'ArticulosRequisicion' => function($req) { //Relacion 1 a 1 De puestos
                        $req->select(
                            'id', 'IdUser', 'Fecha',
                            'IdEmp', 'Folio',
                            'NumReq', 'OrdenCompra',
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
                ])
                ->whereYear('Fecha', $anio)
                ->whereMonth('Fecha', $mes)
                ->where('EstatusArt', '=', $request->Status)
                ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'MotivoRechazo','Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id']);
            }

        }else if($Vista == 2){
            //CONSULTA INICIAL POR AÑO Y MES ACTUAL
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
                'RequisicionesVales' => function($vales) {
                    $vales->select('id', 'IdUser', 'IdEmp', 'Folio', 'Fecha', 'NombreProveedor', 'EstatusVale', 'Salida', 'requisiciones_id');
                },
                'RequisicionArticulos' => function($Req) {
                    $Req->select('id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte' ,'OrdenCompra', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'requisicion_id');
                },
                'RequisicionArticulos.ArticuloPrecios' => function($pre) {
                    $pre->select('id', 'Precio', 'Total', 'Moneda', 'TipoCambio', 'Marca', 'Proveedor', 'Comentarios', 'Archivo', 'Firma', 'NombreProveedor', 'NumCotizacion', 'Autorizado', 'articulos_requisiciones_id', 'requisiciones_id');
                },])
                ->whereYear('Fecha', $anio)
                ->whereMonth('Fecha', $mes)
                ->where('Estatus', '>', 4)
                ->get();

                if($request->Year == 0 && $request->Month == 0 && $request->Status == 0){
                    //CONSULTA TODAS LAS REQUISICIONES
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
                        'RequisicionesVales' => function($vales) {
                            $vales->select('id', 'IdUser', 'IdEmp', 'Folio', 'Fecha', 'NombreProveedor', 'EstatusVale', 'Salida', 'requisiciones_id');
                        },
                        'RequisicionArticulos' => function($Req) {
                            $Req->select('id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte' ,'OrdenCompra', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'requisicion_id');
                        },
                        'RequisicionArticulos.ArticuloPrecios' => function($pre) {
                            $pre->select('id', 'Precio', 'Total', 'Moneda', 'TipoCambio', 'Marca', 'Proveedor', 'Comentarios', 'Archivo', 'Firma', 'NombreProveedor', 'NumCotizacion', 'Autorizado', 'articulos_requisiciones_id', 'requisiciones_id');
                        },
                        ])
                        ->get();
                }elseif ($request->Year == 0 && $request->Month != 0 && $request->Status == 0) {
                    //CONSULTA TODOS LOS MESES SIN IMPORTAR EL AÑO
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
                        'RequisicionesVales' => function($vales) {
                            $vales->select('id', 'IdUser', 'IdEmp', 'Folio', 'Fecha', 'NombreProveedor', 'EstatusVale', 'Salida', 'requisiciones_id');
                        },
                        'RequisicionArticulos' => function($Req) {
                            $Req->select('id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte' ,'OrdenCompra', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'requisicion_id');
                        },
                        'RequisicionArticulos.ArticuloPrecios' => function($pre) {
                            $pre->select('id', 'Precio', 'Total', 'Moneda', 'TipoCambio', 'Marca', 'Proveedor', 'Comentarios', 'Archivo', 'Firma', 'NombreProveedor', 'NumCotizacion', 'Autorizado', 'articulos_requisiciones_id', 'requisiciones_id');
                        },])
                        ->whereMonth('Fecha', $mes)
                        ->where('Estatus', '>', 4)
                        ->get();

                }elseif ($request->Year == 0 && $request->Month == 0 && $request->Status != 0){
                    //CONSULTA EL HISTORICO DE ESTATUS SELECCIONADOS
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
                        'RequisicionesVales' => function($vales) {
                            $vales->select('id', 'IdUser', 'IdEmp', 'Folio', 'Fecha', 'NombreProveedor', 'EstatusVale', 'Salida', 'requisiciones_id');
                        },
                        'RequisicionArticulos' => function($Req) {
                            $Req->select('id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte' ,'OrdenCompra', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'requisicion_id');
                        },
                        'RequisicionArticulos.ArticuloPrecios' => function($pre) {
                            $pre->select('id', 'Precio', 'Total', 'Moneda', 'TipoCambio', 'Marca', 'Proveedor', 'Comentarios', 'Archivo', 'Firma', 'NombreProveedor', 'NumCotizacion', 'Autorizado', 'articulos_requisiciones_id', 'requisiciones_id');
                        },])
                        ->where('Estatus', '=', $request->Status)
                        ->get();
                }elseif ($request->Year == 0 && $request->Month != 0 && $request->Status != 0){
                    //CONSULTA LOS ESTATUS DE MES SELECCIONADO
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
                        'RequisicionesVales' => function($vales) {
                            $vales->select('id', 'IdUser', 'IdEmp', 'Folio', 'Fecha', 'NombreProveedor', 'EstatusVale', 'Salida', 'requisiciones_id');
                        },
                        'RequisicionArticulos' => function($Req) {
                            $Req->select('id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte' ,'OrdenCompra', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'requisicion_id');
                        },
                        'RequisicionArticulos.ArticuloPrecios' => function($pre) {
                            $pre->select('id', 'Precio', 'Total', 'Moneda', 'TipoCambio', 'Marca', 'Proveedor', 'Comentarios', 'Archivo', 'Firma', 'NombreProveedor', 'NumCotizacion', 'Autorizado', 'articulos_requisiciones_id', 'requisiciones_id');
                        },])
                        ->whereMonth('Fecha', $mes)
                        ->where('Estatus', '=', $request->Status)
                        ->get();

                }elseif ($request->Year != 0 && $request->Month == 0 && $request->Status != 0){
                    //CONSULTA EL ESTATUS SELECCIONADO
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
                        'RequisicionesVales' => function($vales) {
                            $vales->select('id', 'IdUser', 'IdEmp', 'Folio', 'Fecha', 'NombreProveedor', 'EstatusVale', 'Salida', 'requisiciones_id');
                        },
                        'RequisicionArticulos' => function($Req) {
                            $Req->select('id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte' ,'OrdenCompra', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'requisicion_id');
                        },
                        'RequisicionArticulos.ArticuloPrecios' => function($pre) {
                            $pre->select('id', 'Precio', 'Total', 'Moneda', 'TipoCambio', 'Marca', 'Proveedor', 'Comentarios', 'Archivo', 'Firma', 'NombreProveedor', 'NumCotizacion', 'Autorizado', 'articulos_requisiciones_id', 'requisiciones_id');
                        },])
                        ->whereYear('Fecha', $anio)
                        ->where('Estatus', '=', $request->Status)
                        ->get();
                }elseif ($request->Year != 0 && $request->Month == 0 && $request->Status != 0){

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
                        'RequisicionesVales' => function($vales) {
                            $vales->select('id', 'IdUser', 'IdEmp', 'Folio', 'Fecha', 'NombreProveedor', 'EstatusVale', 'Salida', 'requisiciones_id');
                        },
                        'RequisicionArticulos' => function($Req) {
                            $Req->select('id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte' ,'OrdenCompra', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'requisicion_id');
                        },
                        'RequisicionArticulos.ArticuloPrecios' => function($pre) {
                            $pre->select('id', 'Precio', 'Total', 'Moneda', 'TipoCambio', 'Marca', 'Proveedor', 'Comentarios', 'Archivo', 'Firma', 'NombreProveedor', 'NumCotizacion', 'Autorizado', 'articulos_requisiciones_id', 'requisiciones_id');
                        },])
                        ->whereYear('Fecha', $anio)
                        ->where('Estatus', '=', $request->Status)
                        ->get();

                }elseif ($request->Year != 0 && $request->Month != 0 && $request->Status != 0){
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
                        'RequisicionesVales' => function($vales) {
                            $vales->select('id', 'IdUser', 'IdEmp', 'Folio', 'Fecha', 'NombreProveedor', 'EstatusVale', 'Salida', 'requisiciones_id');
                        },
                        'RequisicionArticulos' => function($Req) {
                            $Req->select('id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte' ,'OrdenCompra', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'requisicion_id');
                        },
                        'RequisicionArticulos.ArticuloPrecios' => function($pre) {
                            $pre->select('id', 'Precio', 'Total', 'Moneda', 'TipoCambio', 'Marca', 'Proveedor', 'Comentarios', 'Archivo', 'Firma', 'NombreProveedor', 'NumCotizacion', 'Autorizado', 'articulos_requisiciones_id', 'requisiciones_id');
                        },])
                        ->whereYear('Fecha', $anio)
                        ->whereMonth('Fecha', $mes)
                        ->where('Estatus', '=', $request->Status)
                        ->get();
                }
        }

        /* *********** CONSULTAS ESPECIFICAS ****************** */
        if(isset($request->Req)){

            if($request->Req != ''){
                //Consulta que retorna los precios de la requisicion solicitada
                $PreciosRequisicion = PreciosCotizaciones::with(['PreciosArticulo.ArticulosRequisicion'])
                ->where('requisiciones_id', '=', $request->Req)
                ->get();
            }

        }else{

            $PreciosRequisicion = null;
        }

        return Inertia::render('Supply/Requisiciones/Autoriza', compact(
            'Session',
            'Requisiciones',
            'PreciosRequisicion', //Precios de la requisicion solicitada
            'Proveedores',
            'Cotizacion',
            'Pendientes',
            'PendientesMes',
            'Confirmar',
            'ICotizacionMes',
            'mes',
            'Vista',
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
                PreciosCotizaciones::where('requisiciones_id', '=', $request->requisicion_id)
                ->where('NumCotizacion', '=', 1)
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
                PreciosCotizaciones::where('articulos_requisiciones_id', '=', $request->requisicion_id)->where('NumCotizacion', '=', 2)
                ->update([
                    'Autorizado' => 2, //Estatus 2 Autorizado
                ]); //Se autoriza los que tengan estatus 2

                PreciosCotizaciones::where('articulos_requisiciones_id', '=', $request->requisicion_id)->where('NumCotizacion', '!=', 2)
                ->update([
                    'Autorizado' => 1, //Estatus 1 Rechazado
                ]); //Rechazo los precios de la cotizacion 2

                TiemposRequisiciones::where('articulo_requisicion_id', '=', $request->id)->update([
                    'Autorizado' => Carbon::now(),
                ]);

                break;


        }

        switch($request->metodo){
            case 1:

                ArticulosRequisiciones::where('id', '=', $request->articulo_id)->where('EstatusArt', '=', 5)->update([
                    'EstatusArt' => 6,
                ]);

                ArticulosRequisiciones::where('requisicion_id', '=', $request->requisicion_id)->update([
                    'MotivoCancelacion' => $request->Comentario,
                ]);

                //Rechazo ambos precios por defult en caso de haber mas de 1
                PreciosCotizaciones::where('articulos_requisiciones_id', '=', $request->articulo_id)
                ->update([
                    'Autorizado' => 1, //Estatus Rechazado
                ]); //Se rechaza la segunda cotizacion por default

                //Autorizo el precio seleccionado
                PreciosCotizaciones::where('id', '=', $request->precio_id)
                ->update([
                    'Autorizado' => 2, //Estatus 2 Autorizado
                ]); //Se autoriza los que tengan estatus 2

                //Consulta para verificar si aun hay articulos que no estan autorizados
                $ArticulosAutorizados = ArticulosRequisiciones::where('EstatusArt', '=', 5)
                ->where('requisicion_id', '=', $request->requisicion_id)
                ->count();

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

                break;

            case 2: //Rechazo de cotizacion
                ArticulosRequisiciones::where('requisicion_id', '=', $request->requisicion_id)->where('EstatusArt', '=', 5)->update([
                    'EstatusArt' => 6,
                    'MotivoCancelacion' => $request->Comentario,
                ]);

                //Metodos de Rechazo
                PreciosCotizaciones::where('id', '=', $request->precio_id)
                ->update([
                    'Autorizado' => 1, //Estatus 1 Rechazado
                ]);

                break;

            case 3: //Rechazo cotizacion sin Comentario
                //Actualizo el estatus del articulo
                ArticulosRequisiciones::where('id', '=', $request->articulos_requisiciones_id)->where('EstatusArt', '=', 5)->update([
                    'EstatusArt' => 6,
                ]);

                //Autorizo el precio seleccionado
                PreciosCotizaciones::where('id', '=', $request->id)
                ->update([
                    'Autorizado' => 1, //Estatus 1 Autorizado
                ]); //Se autoriza los que tengan estatus 2

                //Busco el id de la requisicion a la que pertenece
                $req = PreciosCotizaciones::where('id', '=', $request->id)->first();

                //Consulta para verificar si aun hay articulos que no estan autorizados
                $ArticulosAutorizados = ArticulosRequisiciones::where('requisicion_id', '=', $req->requisiciones_id)
                ->where('EstatusArt', '=', 5)
                ->count();

                if($ArticulosAutorizados == 0){
                    //Todos los articulos de la requisicion se autorizaron y se manda la cotizacion completa como Autorizada
                    Requisiciones::where('id', '=', $request->requisicion_id)->update([
                        'Estatus' => 6,
                    ]);
                }

                break;
            case 4:
                //Actualizo el estatus del articulo
                ArticulosRequisiciones::where('id', '=', $request->articulos_requisiciones_id)->where('EstatusArt', '=', 5)->update([
                    'EstatusArt' => 6,
                ]);

                //Autorizo el precio seleccionado
                PreciosCotizaciones::where('id', '=', $request->id)
                ->update([
                    'Autorizado' => 2, //Estatus 2 Autorizado
                ]); //Se autoriza los que tengan estatus 2

                //Busco el id de la requisicion a la que pertenece
                $req = PreciosCotizaciones::where('id', '=', $request->id)->first();

                //Consulta para verificar si aun hay articulos que no estan autorizados
                $ArticulosAutorizados = ArticulosRequisiciones::where('requisicion_id', '=', $req->requisiciones_id)
                ->where('EstatusArt', '=', 5)
                ->count();

                if($ArticulosAutorizados == 0){
                    //Todos los articulos de la requisicion se autorizaron y se manda la cotizacion completa como Autorizada
                    Requisiciones::where('id', '=', $request->requisicion_id)->update([
                        'Estatus' => 6,
                    ]);

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
                }
                break;
            case 5:

                $Req = Requisiciones::where('id', '=', $request->requisicion_id)->get(['id','NumReq', 'Fecha', 'OrdenCompra']);

                $correo = new ContactaProveedorMailable($Req);

                Mail::to('programador@hlangeles.com')->send($correo);
                Mail::to('Usir95.hp@gmail.com')->send($correo);

                return "Mensaje Enviado";
                break;
        }

        return redirect()->back();
    }
}
