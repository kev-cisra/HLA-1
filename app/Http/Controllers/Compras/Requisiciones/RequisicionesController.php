<?php

namespace App\Http\Controllers\Compras\Requisiciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Compras\Requisiciones\RequisicionesRequest;
use App\Models\Catalogos\Maquinas;
use App\Models\Compras\Requisiciones\ArticulosRequisiciones;
use App\Models\Compras\Requisiciones\Requisiciones;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Catalogos\JefesArea;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use App\Models\Supply\Requisiciones\TiemposRequisiciones;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

use function PHPUnit\Framework\isNull;

class RequisicionesController extends Controller{

/*  ************************************************
            1 => MATERIAL SOLICITADO
            2 => SOLICITADO
            3 => EN COTIZACION
            4 => COTIZADO
            5 => EN AUTORIZACION
            6 => AUTORIZADO
            7 => CONFIRMADO COMPRAS
            8 => EN ALMACEN
            9 => ENTREGADO
            10 => RECHAZADO
    ************************************************* */
    public function index(Request $request){
        // return $request;
        $hoy = Carbon::now();

        //Asigno el mes actual o uno recibido por request
        $request->Month == '' ? $mes = $hoy->format('n') : $mes = $request->Month;
        $request->Year == '' ? $anio = $hoy->format('Y') : $anio = $request->Year;
        $request->View == '' ? $Vista = 1 : $Vista = intval($request->View);

        $Session = auth()->user(); //Obtengo el Usuario logueado
        $SessionIdEmp = $Session->IdEmp;

        if(count($Session->roles) != 0){
            $Rol = $Session->roles[0]->name; //Obtengo el rol del Usuario logueado
        }else{
            $Rol = "SINROLASIGNADO";
        }

        /* ************** VISTA GENERAL DE DATOS ********************* */
        if($Rol == 'ONEPIECE' || $Rol == 'Administrador'){

            //Obtencion de catalogos globales
            $PerfilesUsuarios = PerfilesUsuarios::get();
            $Departamentos = Departamentos::get(['id','Nombre']);
            $Maquinas = Maquinas::get(['id','Nombre']);

            //Obtencion de Indicadores de Estatus globales
            $Almacen = Requisiciones::where('Estatus', '=', 8)->count();
            $Cotizacion = Requisiciones::whereBetween('Estatus', [3, 4])->count();
            $Autorizados = Requisiciones::where('Estatus', '=', 6)->count();
            $Confirmado = Requisiciones::where('Estatus', '=', 7)->count();

            /* ********************* CONSULTA INICIAL ********************** */

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
                        $req->orderBy('id', 'desc');
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
                ->orderBy('id', 'desc')
                ->get(['id', 'Fecha', 'Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id', 'created_at']);

                if(isset($request->Year)){
                    if($request->Year == 0){
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
                                $req->orderBy('id', 'desc');
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
                        ->orderBy('id', 'desc')
                        ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id', 'created_at']);
                    }else{
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
                                $req->orderBy('id', 'desc');
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
                        ->orderBy('id', 'desc')
                        ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id', 'created_at']);
                        }
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
                    ->whereYear('Fecha', $anio)
                    ->whereMonth('Fecha', $request->Month)
                    ->orderBy('id', 'desc')
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
                        ->whereYear('Fecha', $anio)
                        ->whereMonth('Fecha', $request->Month)
                        ->where('EstatusArt', $request->Status)
                        ->orderBy('id', 'desc')
                        ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id', 'created_at']);
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
                        ->whereYear('Fecha', $anio)
                        ->where('EstatusArt', $request->Status)
                        ->orderBy('id', 'desc')
                        ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id', 'created_at']);
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
                    'RequisicionArticulos' => function($Req) {
                        $Req->select('id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'OrdenCompra', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'requisicion_id', 'created_at');
                    },
                    ])
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
                        'RequisicionArticulos' => function($Req) {
                            $Req->select('id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'OrdenCompra', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'requisicion_id', 'created_at');
                        },
                        ])
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
                        'RequisicionArticulos' => function($Req) {
                            $Req->select('id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'OrdenCompra', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'requisicion_id', 'created_at');
                        },
                        ])
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
                            'RequisicionArticulos' => function($Req) {
                                $Req->select('id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'OrdenCompra', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'requisicion_id', 'created_at');
                            },
                            ])
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
                            'RequisicionArticulos' => function($Req) {
                                $Req->select('id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'OrdenCompra', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'requisicion_id', 'created_at');
                            },
                            ])
                            ->whereYear('Fecha', $anio)
                            ->where('Estatus', $request->Status)
                            ->get();
                    }
                }
            }

        }else{
            /* -------- VISTA DE USUARIOS GENERALES -------------- */

            //Consulta para obtener el id de Jefe de acuerdo al numero de empleado del trabajador
            $ObtenJefe = JefesArea::where('IdEmp', '=', $SessionIdEmp)->first('id','IdEmp');


            if(isset($ObtenJefe)){ //El usuario logueado es un Jefe registrado en la Tabla de Jefes
                $IdJefe = $ObtenJefe->id; //Obtengo el id del Jefe

                if($Session->id == 1360){
                    $PerfilesUsuarios = PerfilesUsuarios::where('jefes_areas_id', '=', 25)->get();
                }else{
                    //Consulta para obtener los datos de los trabajadores pertenecientes al Jefe logueado
                    $PerfilesUsuarios = PerfilesUsuarios::where('jefes_areas_id', '=', $IdJefe)->get();
                }
            }else{
                //En caso contrario es un trabajador Normal (Solo obtengo su registro)
                $PerfilesUsuarios = PerfilesUsuarios::where('IdEmp', '=', $Session->IdEmp)->get();
            }

            //Obtencion de Indicadores por estatus
            $Almacen = Requisiciones::where('Estatus', '=', 8)->where('IdEmp', '=', $Session->IdEmp)->count();
            $Cotizacion = Requisiciones::whereBetween('Estatus', [3, 4])->where('IdEmp', '=', $Session->IdEmp)->count();
            $Autorizados = Requisiciones::where('Estatus', '=', 6)->where('IdEmp', '=', $Session->IdEmp)->count();
            $Confirmado = Requisiciones::where('Estatus', '=', 7)->where('IdEmp', '=', $Session->IdEmp)->count();

            //Obtencion de catalogos
            if($Session->Departamento == 11){
                $Departamentos = Departamentos::get(['id','Nombre']);
                $Maquinas = Maquinas::where('departamento_id', '!=', 7)->get(['id','Nombre']);
            }elseif ($Session->Departamento == 7) {
                $Departamentos = Departamentos::get(['id','Nombre']);
                $Maquinas = Maquinas::where('departamento_id', '!=', 7)->get(['id','Nombre']);
            }else{
                $Departamentos = Departamentos::where('id', '=', $Session->Departamento)->orderBy('Nombre', 'asc')->get(['id','Nombre']);
                $Maquinas = Maquinas::where('departamento_id', '=', $Session->Departamento)->get(['id','Nombre']);
            }

            /*  **************** CONSULTA PRINCIPAL *********************** */
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
                            'Observaciones', 'Perfil_id', 'created_at');
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
                ->where('IdEmp', '=', $Session->IdEmp)
                ->whereYear('Fecha', $anio)
                ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id', 'created_at']);

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
                                'Observaciones', 'Perfil_id', 'created_at');
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
                    ->where('IdEmp', '=', $Session->IdEmp)
                    ->whereYear('Fecha', $anio)
                    ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id', 'created_at']);
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
                    ->where('IdEmp', '=', $Session->IdEmp)
                    ->whereYear('Fecha', $anio)
                    ->whereMonth('Fecha', $request->Month)
                    ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id', 'created_at']);
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
                                    'Observaciones', 'Perfil_id', 'created_at');
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
                        ->where('IdEmp', '=', $Session->IdEmp)
                        ->whereYear('Fecha', $anio)
                        ->whereMonth('Fecha', $request->Month)
                        ->where('EstatusArt', $request->Status)
                        ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id', 'created_at']);
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
                                    'Observaciones', 'Perfil_id', 'created_at');
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
                        ->where('IdEmp', '=', $Session->IdEmp)
                        ->whereYear('Fecha', $anio)
                        ->where('EstatusArt', $request->Status)
                        ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id', 'created_at']);
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
                    'RequisicionArticulos' => function($Req) {
                        $Req->select('id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'OrdenCompra', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'requisicion_id', 'created_at');
                    },
                    ])
                    ->where('IdEmp', '=', $Session->IdEmp)
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
                        'RequisicionArticulos' => function($Req) {
                            $Req->select('id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'OrdenCompra', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'requisicion_id', 'created_at');
                        },
                        ])
                        ->where('IdEmp', '=', $Session->IdEmp)
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
                        'RequisicionArticulos' => function($Req) {
                            $Req->select('id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'OrdenCompra', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'requisicion_id', 'created_at');
                        },
                        ])
                        ->where('IdEmp', '=', $Session->IdEmp)
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
                            'RequisicionArticulos' => function($Req) {
                                $Req->select('id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'OrdenCompra', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'requisicion_id', 'created_at');
                            },
                            ])
                            ->where('IdEmp', '=', $Session->IdEmp)
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
                            'RequisicionArticulos' => function($Req) {
                                $Req->select('id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'OrdenCompra', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'requisicion_id', 'created_at');
                            },
                            ])
                            ->where('IdEmp', '=', $Session->IdEmp)
                            ->whereYear('Fecha', $anio)
                            ->where('Estatus', $request->Status)
                            ->get();
                    }
                }
            }
        }

        return Inertia::render('Compras/Requisiciones/index', compact(
            'Session',
            'PerfilesUsuarios',
            'Requisiciones',
            'Departamentos',
            'Maquinas',
            'Almacen',
            'Cotizacion',
            'Autorizados',
            'Confirmado',
            'Vista',
            'mes'));
    }

    public function RequisicionesMes(Request $request){
        $hoy = Carbon::now();
        $mes = $hoy->format('n');

        $TotalRequisiciones = Requisiciones::whereMonth('Fecha',$mes)->count();

        $Solicitdado = Requisiciones::whereMonth('Fecha',$mes)->where('Estatus', '=', 2)->count();
        $Cotizacion = Requisiciones::whereMonth('Fecha',$mes)->where('Estatus', '=', 3)->count();
        $Cotizado = Requisiciones::whereMonth('Fecha',$mes)->where('Estatus', '=', 4)->count();
        $Autorizacion = Requisiciones::whereMonth('Fecha',$mes)->where('Estatus', '=', 5)->count();
        $Autorizado = Requisiciones::whereMonth('Fecha',$mes)->where('Estatus', '=', 6)->count();
        $Confirmado = Requisiciones::whereMonth('Fecha',$mes)->where('Estatus', '=', 7)->count();
        $Almacen = Requisiciones::whereMonth('Fecha',$mes)->where('Estatus', '=', 8)->count();
        $Entregado = Requisiciones::whereMonth('Fecha',$mes)->where('Estatus', '=', 9)->count();

        $Informacion = [
        'Solicitdado'=> $Solicitdado,
        'Cotizacion' => $Cotizacion,
        'Cotizado' => $Cotizado,
        'Autorizacion' => $Autorizacion,
        'Autorizado' => $Autorizado,
        'Confirmado' => $Confirmado,
        'Almacen' => $Almacen,
        'Entregado' => $Entregado];

        return $Informacion;
    }

    public function store(RequisicionesRequest $request){

        $hoy = Carbon::now();
        $anio = $hoy->format('y');

        $Session = auth()->user();
        $SessionIdEmp = $Session->IdEmp;

        //Consulta pra obtener el id de Jefe de acuerdo al numero de empleado del trabajador
        $ObtenJefe = JefesArea::where('IdEmp', '=', $request->IdEmp)->first('id','IdEmp');
        if(isset($ObtenJefe)){
            $IdJefe = $ObtenJefe->id; //Obtengo el Id del Jefe logueado
        }else{
            $PerfilesUsuarios = PerfilesUsuarios::where('IdEmp', '=', $request->IdEmp)->first(['id','jefes_areas_id']);
            $IdJefe = $PerfilesUsuarios->jefes_areas_id; //Obtengo el Id de Jefe que corresponde a la session del empleado
        }

        //Genracion de folio automatico
        $Numfolio = Requisiciones::all(['Folio']);

        $Nfolio = $Numfolio->last(); //Obtengo el ultimo folio con el metodo last
        $AnioBd = substr($Nfolio->Folio, 0, 2); //Obtengo el año del folio

        $serial = $Nfolio->Folio; //asigno el folio a la variable serial
        $serial = substr($serial, 2); //Obtengo el folio sin el año

        $AnioBd == $anio ?  $serial += 1 :  $serial = 1;

        $Requisicion = Requisiciones::create([
            'IdUser' => $request->IdUser,
            'IdEmp' => $Session->IdEmp,
            'Fecha' => $request->Fecha,
            'Folio' => $anio.$serial,
            'NumReq' => $request->NumReq,
            'Departamento_id' => $request->Departamento_id,
            'jefes_areas_id' => $IdJefe,
            'Codigo' => $request->Codigo,
            'Maquina_id' => $request->Maquina,
            'Marca_id' => $request->Marca,
            'TipCompra' => $request->Tipo,
            'Observaciones' => $request->Observaciones,
            'Perfil_id' => $request->Nombre,
            'Estatus' => 1,
        ]);

        $RequicisionId = $Requisicion->id;

        foreach ($request->Partida as $value) {

            if(!empty($value['NumParte'])){
                $NumParte = $value['NumParte'];
            }else{
                $NumParte = '';
            }

            $Articulos = ArticulosRequisiciones::create([
                'IdEmp' => $Session->IdEmp,
                'Fecha' => $request->Fecha,
                'Cantidad' => $value['Cantidad'],
                'Unidad' => $value['Unidad'],
                'NumParte' => $NumParte,
                'Descripcion' => $value['Descripcion'],
                'EstatusArt' => 1,
                'requisicion_id' => $RequicisionId,
            ]);

            $ArticulosId = $Articulos->id;

            $TiempoReq = TiemposRequisiciones::create([
                'IdUser' => $Session->id,
                'IdEmp' => $Session->IdEmp,
                'requisicion_id' => $RequicisionId,
                'articulo_requisicion_id' => $ArticulosId,
            ]);
        }

        return redirect()->back();
    }

    public function update(Request $request, $id){

        $hoy = Carbon::now();

        switch($request->metodo){
            //Caso de actualizacion de informacion
            case 1:

                Validator::make($request->all(), [
                    'IdUser' => ['required'],
                    'IdEmp' => ['required'],
                    'Fecha' => ['required'],
                    'Departamento_id' => ['required'],
                    'NumReq' => ['required'],
                    'Codigo' => ['required'],
                    'Maquina' => ['required'],
                    'Marca' => ['required'],
                    'Tipo' => ['required'],
                    'Nombre' => ['required'],
                    'Marca' => ['required'],
                    'Observaciones' => ['required'],
                ])->validate();

                Requisiciones::find($request->ReqId)->update([
                    'IdUser' => $request->IdUser,
                    'Departamento_id' => $request->Departamento_id,
                    'NumReq' => $request->NumReq,
                    'Codigo' => $request->Codigo,
                    'Maquina_id' => $request->Maquina,
                    'Marca_id' => $request->Marca,
                    'TipCompra' => $request->Tipo,
                    'Perfil_id' => $request->Nombre,
                    'Observaciones' => $request->Observaciones,
                ]);

                ArticulosRequisiciones::find($request->ArtId)->update([
                    'Fecha' => $request->Fecha,
                    'Cantidad' => $request->Cantidad,
                    'Unidad' => $request->Unidad,
                    'Descripcion' => $request->Descripcion,
                ]);

                return redirect()->back();
                break;

            // CASO DE CONFIRMACION DE REQUISICION
            case 2:

                ArticulosRequisiciones::where('requisicion_id', '=', $request->id)->update([
                    'EstatusArt' => 2,
                ]);

                Requisiciones::where('id', '=', $request->id)->update([
                    'Estatus' => 2,
                ]);

                TiemposRequisiciones::where('requisicion_id', '=', $request->id)->update([
                    'Solicitado' => $hoy,
                ]);

                return redirect()->back();
                break;

            //CASO DE CONFIRMACION DESDE LA PARTIDA
            case 3:

                $Req = ArticulosRequisiciones::where('id', '=', $request->id)->first();

                Requisiciones::where('id', '=', $Req->requisicion_id)->update([
                    'Estatus' => 2,
                ]);

                ArticulosRequisiciones::where('requisicion_id', '=', $Req->requisicion_id)->update([
                    'EstatusArt' => 2,
                ]);

                return redirect()->back();
                break;

            case 20:

                $users = User::get();

                view()->share('users', $users);

                return PDF::download('Print/index.pdf');

                break;

        }

    }

    public function destroy($id){
        //
    }
}
