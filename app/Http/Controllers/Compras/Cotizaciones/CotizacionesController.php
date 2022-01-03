<?php

namespace App\Http\Controllers\Compras\Cotizaciones;

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
use PhpParser\Node\Stmt\Return_;

use function PHPUnit\Framework\isNull;

class CotizacionesController extends Controller{

    public function index(Request $request){

        $Session = auth()->user();
        $hoy = Carbon::now();
        //Obtencion de filtros para Fechas
        $request->Month == '' ? $mes = $hoy->format('n') : $mes = $request->Month;
        $request->Year == '' ? $anio = $hoy->format('Y') : $anio = $request->Year;
        $request->View == '' ? $Vista = 1 : $Vista = $request->View;

        //Obtengo el catalogo de proveedores
        $Proveedores = Proveedores::get();

        //Indicadores
        $Almacen = Requisiciones::where('Estatus', '=', 8)->count();
        $Cotizacion = Requisiciones::where('Estatus', '=', 3)->count();
        $SinConfirmar = Requisiciones::where('Estatus', '=', 5)->count();
        $Autorizados = Requisiciones::where('Estatus', '=', 5)->count();
        $EnCotizacion = Requisiciones::where('Estatus', '=', 6)->count();
        $Precios = Requisiciones::with('ArticuloPrecios')->get();

        $ArticulosRequisicion = null;
        $ArticulosCotizar = null;
        $ArticulosPrecios = null;
        $PreciosRequisicion = null;
        $PrecioEdit = null;
        $Req = null;
        $Precio = null;
        $NumCot = null;

        /* *********************************** CONSULTA PRINCIPAL ********************************* */
        if($Vista == 1){
            //Consulta por Articulos con filtro de Año
            $Requisiciones = ArticulosRequisiciones::with([
                'ArticulosRequisicion' => function($req) { //Relacion 1 a 1 De puestos
                    $req->select(
                        'id', 'IdUser',
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
            ->where('EstatusArt', '>', 2)
            ->whereYear('Fecha', $anio)
            ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id']);

            if(isset($request->Year)){
                //CONSULTA FILTRADA POR AÑO
                $Requisiciones = ArticulosRequisiciones::with([
                    'ArticulosRequisicion' => function($req) { //Relacion 1 a 1 De puestos
                        $req->select(
                            'id', 'IdUser',
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
                ->where('EstatusArt', '>', 2)
                ->whereYear('Fecha', $anio)
                ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id']);
            }

            if ($request->Month != 0 && $request->Status == 0) {
                //CONSULTA FILTRADA SOLO POR MES
                $Requisiciones = ArticulosRequisiciones::with([
                    'ArticulosRequisicion' => function($req) { //Relacion 1 a 1 De puestos
                        $req->select(
                            'id', 'IdUser',
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
                ->where('EstatusArt', '>', 2)
                ->whereYear('Fecha', $anio)
                ->whereMonth('Fecha', $request->Month)
                ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id']);
            }

            if($request->Status != 0){
                //FILTRO POR ESTATUS
                if($request->Month != 0){
                    //FILTRO POR ESTATUS Y MES
                    $Requisiciones = ArticulosRequisiciones::with([
                        'ArticulosRequisicion' => function($req) { //Relacion 1 a 1 De puestos
                            $req->select(
                                'id', 'IdUser',
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
                    ->where('EstatusArt', '>', 2)
                    ->whereYear('Fecha', $anio)
                    ->whereMonth('Fecha', $request->Month)
                    ->where('EstatusArt', $request->Status)
                    ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id']);
                }else{
                    //FILTRO UNICAMENTE POR ESTATUS
                    $Requisiciones = ArticulosRequisiciones::with([
                        'ArticulosRequisicion' => function($req) { //Relacion 1 a 1 De puestos
                            $req->select(
                                'id', 'IdUser',
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
                    ->where('EstatusArt', '>', 2)
                    ->whereYear('Fecha', $anio)
                    ->where('EstatusArt', $request->Status)
                    ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id']);
                }
            }

        }else if($Vista == 2){
            //Consulta por Requisiciones con Filtro por Año
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
                ->where('Estatus', '>', 2)
                ->whereYear('Fecha', $anio)
                ->get();

            if(isset($request->Year)){
                //CONSULTA FILTRADA POR AÑO
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
                        $Req->select('id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'OrdenCompra', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'requisicion_id');
                    },
                    'RequisicionArticulos.ArticuloPrecios' => function($pre) {
                        $pre->select('id', 'Precio', 'Total', 'Moneda', 'TipoCambio', 'Marca', 'Proveedor', 'Comentarios', 'Archivo', 'Firma', 'NombreProveedor', 'NumCotizacion', 'Autorizado', 'articulos_requisiciones_id', 'requisiciones_id');
                    },
                    ])
                    ->where('Estatus', '>', 2)
                    ->whereYear('Fecha', $anio)
                    ->get();
            }

            if ($request->Month != 0 && $request->Status == 0) {
                //CONSULTA FILTRADA SOLO POR MES
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
                        $Req->select('id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'OrdenCompra', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'requisicion_id');
                    },
                    'RequisicionArticulos.ArticuloPrecios' => function($pre) {
                        $pre->select('id', 'Precio', 'Total', 'Moneda', 'TipoCambio', 'Marca', 'Proveedor', 'Comentarios', 'Archivo', 'Firma', 'NombreProveedor', 'NumCotizacion', 'Autorizado', 'articulos_requisiciones_id', 'requisiciones_id');
                    },
                    ])->where('Estatus', '>', 2)
                    ->whereMonth('Fecha', $request->Month)
                    ->whereYear('Fecha', $anio)
                    ->get();
            }

            if($request->Status != 0){
                //FILTRO POR ESTATUS
                if($request->Month != 0){
                    //FILTRO POR ESTATUS Y MES
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
                            $Req->select('id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'OrdenCompra', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'requisicion_id');
                        },
                        ])
                        ->where('Estatus', '>', 2)
                        ->whereYear('Fecha', $anio)
                        ->whereMonth('Fecha', $request->Month)
                        ->where('Estatus', $request->Status)
                        ->get();
                }else{
                    //FILTRO UNICAMENTE POR ESTATUS
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
                            $Req->select('id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'OrdenCompra', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'requisicion_id');
                        },
                        ])
                        ->where('Estatus', '>', 2)
                        ->whereYear('Fecha', $anio)
                        ->where('Estatus', $request->Status)
                        ->get();
                }
            }
        }

        if($request->Req != ''){ //Obtencion del id de la requisicion

            $Req = Requisiciones::where('id', '=', $request->Req)->get(); //Obtener el Num de requisicion
            //Cuento el numero de cotizaciones realizadas
            $NumCot = PreciosCotizaciones::where('NumCotizacion', '=', 2)->where('requisiciones_id', '=', $request->Req)->count();

            //Consulta para obtener las partidas relacionadas a esa requisicion
            $ArticulosRequisicion = ArticulosRequisiciones::where('requisicion_id','=', $request->Req)->get();

            //Consulta los articulos con sus precios correspondientes
            $ArticulosPrecios = ArticulosRequisiciones::with([
                'ArticuloPrecios' => function($pre) { //Relacion 1 a 1 De puestos
                    $pre->select('id', 'Precio', 'Total', 'Moneda', 'TipoCambio', 'Marca', 'Proveedor', 'Comentarios', 'Archivo', 'Autorizado', 'articulos_requisiciones_id', 'requisiciones_id');
                },
            ])
            ->where('requisicion_id', '=', $request->Req)
            ->where('EstatusArt', '!=', 10)
            ->get();

            $PreciosRequisicion = PreciosCotizaciones::where('requisiciones_id', '=', $request->Req)->get();

            //Consulta para obtener los articulos a cotizar dinamicamente
            if($request->NumCot == 1){
                //Obtengo los articulos son cotizar
                $ArticulosCotizar = ArticulosRequisiciones::where('requisicion_id','=', $request->Req)->where('EstatusArt', '=', 3)->get();
            }else{
                //Obtengo los articulos cotizados 1 vez
                $ArticulosCotizar = ArticulosRequisiciones::where('requisicion_id','=', $request->Req)->where('EstatusArt', '=', 4)->get();
            }

            if($request->Art != ''){
                //Obtengo los datos de la requisicion a editar
                $Precio = ArticulosRequisiciones::with([
                    'ArticuloPrecios' => function($pre) { //Relacion 1 a 1 De puestos
                        $pre->select('id', 'Precio', 'Total', 'Moneda', 'TipoCambio', 'Marca', 'Proveedor', 'Comentarios', 'Archivo', 'NumCotizacion', 'Autorizado', 'articulos_requisiciones_id', 'requisiciones_id');
                    },
                ])
                ->where('id', '=', $request->Art)
                ->get();

                $PrecioEdit = PreciosCotizaciones::where('articulos_requisiciones_id', '=', $request->Art)->get();
            }

        }

        return Inertia::render('Compras/Cotizaciones/Cotizaciones', compact(
            'Session',
            'Req', //Numero de requisicion
            'NumCot', //Numero de cotizaciones realizadas
            'Precio', //Obtengo los precios relacionados al articulo
            'Proveedores',
            'Requisiciones',
            'PrecioEdit',
            'ArticulosRequisicion',
            'ArticulosCotizar',
            'ArticulosPrecios',
            'PreciosRequisicion',
            'Cotizacion',
            'SinConfirmar',
            'EnCotizacion',
            'Vista',
            'mes',
        ));
    }


    public function store(Request $request){

        if(isset($request)){ //Verifico la existencia de datos
            // return $request;
            if(isset($request->archivo)){ //Valido envio de Archivo

                Validator::make($request->all(), [
                    'archivo' => 'required|mimes:jpg,png,jpeg,svg,pdf',
                ])->validate();

                $file = $request->file("archivo")->getClientOriginalName(); //Obtengo el nombre del archivo y su extancion

                //Guardado de Imagen en la carpeta Public/Storage.. (Uso del disco Public pora la restriccion de los archivos)
                $url = $request->archivo->storePubliclyAs('Archivos/Compras/Requisiciones/Cotizaciones',  $file, 'public');
            }else{
                $url = 'Archivos/FileNotFound404.jpg';
            }
            // Ciclo de guardado de precios de la requisicion (hay duplicidad de datos por un cambio que pidieron
            //con el sistema ya en produccion por lo cual se tuvo que dejar asi debido a como se trabajaba antiguamente el sistema)
            foreach ($request->PrecioCotizacion as $value) {

                if($request->Moneda == 'MXN'){ //Obtengo el tipo de moneda
                    $Total = $value['PrecioUnitario'] * $value['Cantidad']; //Calculo el total
                    $Total = $Total;
                    $TipoCambio = 0;
                }else{
                    $TipoCambio = $request->TipoCambio;
                    $Total1 = round($value['PrecioUnitario'] * $request->TipoCambio, 2); //Calculo el total del Precio Unitario
                    $Total = $Total1 * $value['Cantidad']; //Calculo el otal del la cotizacion
                    $Total = $Total;
                }

                //Obtengo el numero de cotizaciones guardadas para esa requisicion
                $NumCotizaciones = PreciosCotizaciones::where('articulos_requisiciones_id', '=', $value['IdArt'])
                    ->where('NumCotizacion', '=', 1)
                    ->count();

                if($NumCotizaciones == 0){ //Asigno el numero de cotizacion correspondiente
                    $NumCot = 1;
                }else{
                    $NumCot = 2;
                }

                $Cotizacion = PreciosCotizaciones::create([
                    'IdUser' => $request->IdUser,
                    'Precio' => $value['PrecioUnitario'],
                    'Total' => $Total,
                    'Moneda' => $request->Moneda,
                    'TipoCambio' => $TipoCambio,
                    'Marca' => $request->Marca,
                    'Proveedor' => $request->Proveedor,
                    'Comentarios' => $request->Comentarios,
                    'Archivo' => $url,
                    'articulos_requisiciones_id' => $value['IdArt'],
                    'requisiciones_id' => $value['requisicion_id'],
                    'NumCotizacion' => $NumCot,
                ]);

                //Actualizo el estatus de la requisicion
                Requisiciones::where('id', '=', $value['requisicion_id'])->update([
                    'Estatus' => 4,
                ]);
                //Actuyalizo el estatus de los articulos de la requisicion
                ArticulosRequisiciones::where('id', '=', $value['IdArt'])->update([
                    'EstatusArt' => 4,
                ]);
            }

            return redirect()->back();

        }else{
            return "Ocurrio un Error Intente nuevamente";
        }

    }

    public function update(Request $request, $id){

        switch($request->metodo){
            //Actualizacion del precio del articulo de la requisicion
            case 1: {
                $Session = auth()->user();

                if($request->Moneda == 'MXN'){ //Verifico el tipo de moneda
                    $Total = $request->Precio * $request->Cantidad;
                }else{
                    $Total1 = round($request->Precio * $request->TipoCambio, 2);
                    $Total = $Total1 * $request->Cantidad; //Calculo el total de acuerdo el tipo de cambio
                }

                if(isset($request->archivo)){
                    //Verifico la existencia de un archivo subido
                    Validator::make($request->all(), [
                        'archivo' => 'required|mimes:jpg,png,jpeg,svg,pdf',
                    ])->validate();

                    $file = $request->file("archivo")->getClientOriginalName(); //Obtengo el nombre del archivo y su extancion

                    //Guardado de Imagen en la carpeta Public/Storage.. (Uso del disco Public pora la restriccion de los archivos)
                    $url = $request->archivo->storePubliclyAs('Archivos/Compras/Requisiciones/Cotizaciones',  $file, 'public');

                }else{
                    //Busco la url del archivo adjuntado anteriormente
                    $Precio = PreciosCotizaciones::find($request->editId)->first();
                    $url = $Precio->Archivo;
                }

                //Actualizacion de datos
                PreciosCotizaciones::find($request->editId)->update([
                    'IdUser' => $request->IdUser,
                    'Precio' => $request->Precio,
                    'Total' => $Total,
                    'Moneda' => $request->Moneda,
                    'TipoCambio' => $request->TipoCambio,
                    'Marca' => $request->Marca,
                    'Proveedor' => $request->Proveedor,
                    'Comentarios' => $request->Comentarios,
                    'Archivo' => $url,
                ]);
                break;
            }

            //Envio de cotizacion a autorizacion
            case 2:{
                //Envio a autorizacion solo los articulos cotizados por primer o segunda vez
                ArticulosRequisiciones::where('requisicion_id', '=', $request->id)->where('EstatusArt', '=', 3)->update([
                    'EstatusArt' => 5,
                ]);

                ArticulosRequisiciones::where('requisicion_id', '=', $request->id)->where('EstatusArt', '=', 4)->update([
                    'EstatusArt' => 5,
                ]);

                //Envio a autorizacion la requisicion
                Requisiciones::find($request->id)->update([
                    'Estatus' => 5,
                ]);

                TiemposRequisiciones::where('articulo_requisicion_id', '=', $request->id)->update([
                    'Cotizado' => Carbon::now(),
                ]);

                break;
            }

            //Agregar comentario de fecha de llegada
            case 3:{
                ArticulosRequisiciones::where('requisicion_id', '=', $request->requisicion_id)->update([
                    'Fechallegada' => $request->Fechallegada,
                    'Comentariollegada' => $request->Comentariollegada,
                    'EstatusArt' => 7,
                ]);

                Requisiciones::find($request->requisicion_id)->update([
                    'Estatus' => 7,
                ]);

                break;
            }

            //Agrega comentario de Cancelacion
            case 4:{
                ArticulosRequisiciones::where('id', '=', $request->IdArt)->update([
                    'MotivoCancelacion' => $request->MotivoCancelacion,
                    'EstatusArt' => 10,
                ]);
            }
        }

        return redirect()->back();

    }
}
