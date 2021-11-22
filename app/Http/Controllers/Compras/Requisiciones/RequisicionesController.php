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
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

use function PHPUnit\Framework\isNull;

class RequisicionesController extends Controller{

/*     ************************************************
            1 => MATERIAL SOLICITADO
            2 => SOLICITADO
            3 => EN COTIZACION
            4 => COTIZADO
            5 => EN AUTORIZACION
            6 => AUTORIZADO
            7 => CONFIRMADO COMPRAS
            8 => EN ALMACEN
            9 => ENTREGAD10
            10 => RECHAZADO
    ************************************************* */

    public function index(Request $request){

        $hoy = Carbon::now();

        $request->month == '' ? $mes = $hoy->format('n') : $mes = $request->month;
        $anio = 2021;

        $Session = auth()->user();
        $SessionIdEmp = $Session->IdEmp;

        if(count($Session->roles) != 0){
            $Rol = $Session->roles[0]->name;
        }else{
            $Rol = "SINROLASIGNADO";
        }

        if($Rol != 'ONEPIECE' && $Rol != 'Administrador'){ //Vista de requisiciones por IdEmp
            //Consulta para obtener el id de Jefe de acuerdo al numero de empleado del trabajador
            $ObtenJefe = JefesArea::where('IdEmp', '=', $SessionIdEmp)->first('id','IdEmp');

            if(isset($ObtenJefe)){ //El usuario logueado esta registrado en la tabla de Jefes
                $IdJefe = $ObtenJefe->id; //Obtengo el id de trabajador de acuerdo al idEmpleado de la session

                //Consulta para obtener los datos de los trabajadores pertenecientes al id de la session del Jefe
                $PerfilesUsuarios = PerfilesUsuarios::where('jefes_areas_id', '=', $IdJefe)->get();
            }else{
                //En caso contrario Obtengo el Usuario Logueado
                $PerfilesUsuarios = PerfilesUsuarios::where('IdEmp', '=', $Session->IdEmp)->get();
            }

                if($Session->Departamento == 11){
                    $Departamentos = Departamentos::get(['id','Nombre']);
                    $Maquinas = Maquinas::where('departamento_id', '!=', 7)->get(['id','Nombre']);
                }else{
                    $Departamentos = Departamentos::where('id', '=', $Session->Departamento)->orderBy('Nombre', 'asc')->get(['id','Nombre']);
                    $Maquinas = Maquinas::where('departamento_id', '=', $Session->Departamento)->get(['id','Nombre']);
                }

                //Consulta general por Fecha
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
                    ->where('IdEmp', '=', $Session->IdEmp)
                    ->whereMonth('Fecha', $mes)
                    ->get();

                if($request->Estatus){ //Filtro solo por Estatus

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
                        ->where('IdEmp', '=', $Session->IdEmp)
                        ->where('Estatus', $request->Estatus)
                        ->get();
                }

            //INDICADORES DE ESTATUS POR SESSION
            $Almacen = Requisiciones::where('Estatus', '=', 8)->where('IdEmp', '=', $Session->IdEmp)->count();
            $Cotizacion = Requisiciones::whereBetween('Estatus', [3, 4])->where('IdEmp', '=', $Session->IdEmp)->count();
            $Autorizados = Requisiciones::where('Estatus', '=', 6)->where('IdEmp', '=', $Session->IdEmp)->count();
            $Confirmado = Requisiciones::where('Estatus', '=', 7)->where('IdEmp', '=', $Session->IdEmp)->count();

        }else{ //Vista de ADMINISTRADOR

            $PerfilesUsuarios = PerfilesUsuarios::get();
            $Departamentos = Departamentos::get(['id','Nombre']);
            $Maquinas = Maquinas::get(['id','Nombre']);

                //INDICADORES DE ESTATUS POR GLOABALES
                $Almacen = Requisiciones::where('Estatus', '=', 8)->count();
                $Cotizacion = Requisiciones::whereBetween('Estatus', [3, 4])->count();
                $Autorizados = Requisiciones::where('Estatus', '=', 6)->count();
                $Confirmado = Requisiciones::where('Estatus', '=', 7)->count();

            if($mes != ''){
                //Consulta de Requisiciones por Fecha
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
                    // ->groupBy('Estatus')
                    ->orderBy('NumReq', 'desc')
                    ->whereYear('Fecha', $anio)
                    ->whereMonth('Fecha', $mes)
                    ->get();
            }

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
                    // ->groupBy('Estatus')
                    // ->orderBy('NumReq', 'desc')
                    ->whereYear('Fecha', $anio)
                    ->where('Estatus', $request->Estatus)
                    ->get();
            }
        }

        if($request->Req != ''){

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
            ])
            ->where('requisicion_id','=', $request->Req)
            ->orderBy('EstatusArt', 'asc')
            ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id']);

        }else{
            $ArticulosRequisiciones = null;
        }


        return Inertia::render('Compras/Requisiciones/index', compact(
            'Session',
            'PerfilesUsuarios',
            'Requisiciones',
            'ArticulosRequisiciones',
            'Departamentos',
            'Maquinas',
            'Almacen',
            'Cotizacion',
            'Autorizados',
            'Confirmado',
            'mes'));
    }

    public function store(RequisicionesRequest $request){

        $hoy = Carbon::now();

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

        if($Numfolio->count()){
            $Nfolio = $Numfolio->last(); //Obtengo el ultimo folio con el metodo last

            foreach ($Nfolio as $item){
                $serial = $Nfolio->Folio; //asigno el folio a la variable serial
            }
        }else{
            $serial = 1000; //en caso de no haber registros asigno un folio
        }
        $serial += 1; //Incremento de folio

        $Requisicion = Requisiciones::create([
            'IdUser' => $request->IdUser,
            'IdEmp' => $Session->IdEmp,
            'Fecha' => $request->Fecha,
            'Folio' => $serial,
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
        }

    }

    public function destroy($id){
        //
    }
}
