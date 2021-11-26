<?php

namespace App\Http\Controllers\Almacen\Requisiciones;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\Maquinas;
use App\Models\Compras\Requisiciones\ArticulosRequisiciones;
use App\Models\Compras\Requisiciones\Requisiciones;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Catalogos\JefesArea;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use App\Models\Supply\Requisiciones\TiemposRequisiciones;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\Return_;

class RequisicionesSolicitadasController extends Controller {

    public function index(Request $request){

        $Session = auth()->user();
        $hoy = Carbon::now();
        //Obtencion de filtros para Fechas
        $request->month == '' ? $mes = $hoy->format('n') : $mes = $request->month;
        $anio = 2021;

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
                ->where('Estatus', '>', 1)
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
            ])
            ->whereMonth('Fecha', $mes)
            ->where('EstatusArt', '>', 1)
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
                ->where('Estatus', '>', 1)
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
            ])
            ->where('EstatusArt', '>', 1)
            ->where('EstatusArt', $request->Estatus)
            ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id']);

        }

        //Filtro por Partidas pertenecientes a una Requisicion
        if($request->Req != ''){

            $ArticulosRequisicion = ArticulosRequisiciones::with([
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
            $ArticulosRequisicion = null;
        }

        // Indicadores de Estatus de requisiciones
        $Almacen = Requisiciones::where('Estatus', '=', 8)->count();

        $Cotizacion = Requisiciones::whereBetween('Estatus', [3, 4])->count();

        $SinConfirmar = Requisiciones::where('Estatus', '=', 7)->count();

        return Inertia::render('Almacen/Requisiciones/Requisiciones',
        compact('Session',
        'Requisiciones',
        'ArticulosRequisiciones',
        'ArticulosRequisicion',
        'Almacen',
        'Cotizacion',
        'SinConfirmar',
        'mes'));
    }

    public function store(Request $request){

        $hoy = Carbon::now();

        $Session = auth()->user();
        $SessionIdEmp = $Session->IdEmp;

        //Consulta pra obtener el id de Jefe de acuerdo al numero de empleado del trabajador
        $ObtenJefe = JefesArea::where('IdEmp', '=', $Session->IdEmp)->first('id','IdEmp');
        if(isset($ObtenJefe)){
            $IdJefe = $ObtenJefe->id; //Obtengo el Id del Jefe logueado
        }else{
            $PerfilesUsuarios = PerfilesUsuarios::where('IdEmp', '=', $Session->IdEmp)->first(['id','jefes_areas_id']);
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
            'IdUser' => $Session->id,
            'IdEmp' => $request->IdEmp,
            'Folio' => $serial,
            'NumReq' => $request->NumReq."-S",
            'Departamento_id' => $request->Dpto,
            'jefes_areas_id' => $IdJefe,
            'Codigo' => $request->Codigo,
            'Maquina_id' => $request->Maq,
            'Marca_id' => $request->Mar,
            'TipCompra' => $request->TipCompra,
            'Observaciones' => "Reposicion de Stock",
            'Perfil_id' => $Session->id,
        ]);

        $RequicisionId = $Requisicion->id;

        $Articulos = ArticulosRequisiciones::create([
            'IdEmp' => $Session->IdEmp,
            'Fecha' => $request->Fecha,
            'Cantidad' => $request->Cant,
            'Unidad' => $request->Uni,
            'NumParte' => $request->NumParte,
            'Descripcion' => $request->Desc,
            'EstatusArt' => 3,
            'requisicion_id' => $RequicisionId,
        ]);

        $ArticulosId = $Articulos->id;

        $TiempoReq = TiemposRequisiciones::create([
            'IdUser' => $Session->id,
            'IdEmp' => $Session->IdEmp,
            'requisicion_id' => $RequicisionId,
            'articulo_requisicion_id' => $ArticulosId,
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id){

        if($request->metodo == 'Parcialidad'){

            $id = $request->IdArt;

            //Obtengo la cantidad solicitada previamente
            $Articulo = ArticulosRequisiciones::where('id', '=', $request->IdArt)->first();
            $Articulo->Cantidad;

            //Resto la diferencia que existen en almacen
            $Par = $Articulo->Cantidad - $request->Parcialidad;

            ArticulosRequisiciones::where('id', '=', $id)->update([
                'Cantidad' => $Par,
            ]);

            $Parcialidad = ArticulosRequisiciones::create([
                'Fecha' => $Articulo->Fecha,
                'Cantidad' => $request->Parcialidad,
                'Unidad' => $Articulo->Unidad,
                'Descripcion' => $Articulo->Descripcion,
                'EstatusArt' => $Articulo->EstatusArt,
                'requisicion_id' => $Articulo->requisicion_id,
            ]);

        }else{

            switch ($request->metodo) {
                //CASO DE ENVIAR REQUISICION A COTIZACION
                case 1:

                    //Reviso si hay articulos en Estatus de Solicitud para actualizarlos
                    $Solicitado = ArticulosRequisiciones::where('requisicion_id', '=', $request->id)->where('EstatusArt', '=', 2)->count();

                    if($Solicitado > 0){
                        //Actualizo los articulos que aun esten estatus 2 (Solicitud)
                        ArticulosRequisiciones::where('requisicion_id', '=', $request->id)->where('EstatusArt', '=', 2)->update([
                            'EstatusArt' => 3,
                        ]);
                    }

                    Requisiciones::find($request->id)->update([
                        'Estatus' => 3,
                    ]);

                    TiemposRequisiciones::where('requisicion_id', '=', $request->id)->update([
                        'Revision' => Carbon::now(),
                    ]);

                    return redirect()->back();
                    break;

                //CASO DE CONFIRMAR EXISTENCIA DE REQUISICION EN ALMACEN
                case 2:

                    //Reviso si hay articulos en Estatus de Almacen para actualizarlos
                    $Almacen = ArticulosRequisiciones::where('requisicion_id', '=', $request->id)->where('EstatusArt', '=', 8)->count();

                    if($Almacen > 0){
                        ArticulosRequisiciones::where('requisicion_id', '=', $request->id)->where('EstatusArt', '=', 8)->update([
                            'EstatusArt' => 8,
                        ]);
                    }

                    Requisiciones::find($request->id)->update([
                        'Estatus' => 8,
                    ]);

                    TiemposRequisiciones::where('requisicion_id', '=', $request->id)->update([
                        'Almacen' => Carbon::now(),
                    ]);

                    return redirect()->back();

                    break;
                //VERIFICA CONTRASEÑA Y USUARIO CORRECTOS
                case 3:

                    $User = User::where('IdEmp', '=', $request->User)->first(['id', 'IdEmp', 'password']);

                    if(!empty($User->IdEmp)){

                        $User->IdEmp;
                        $User->password;

                        if($request->User == $User->IdEmp){

                            if (Hash::check($request->Pass, $User->password)){

                                Requisiciones::where('id', '=', $request->IdArt)->update([
                                    'Estatus' => 9,
                                ]);

                                ArticulosRequisiciones::where('requisicion_id', '=', $request->IdArt)->update([
                                    'EstatusArt' => 9,
                                    'RecibidoPor' => $User->id,
                                ]);

                                TiemposRequisiciones::where('articulo_requisicion_id', '=', $request->IdArt)->update([
                                    'Entregado' => Carbon::now(),
                                ]);

                                return redirect()->back();

                            }else{
                                return back()->with([
                                    'flash' => 3,
                                ]);
                            }
                        }else{
                            return back()->with([
                                'flash' => 2,
                            ]);
                        }
                    }else{
                        return back()->with([
                            'flash' => 1,
                        ]);
                    }
                    break;

                //CASO DE MANDAR A COTIZAR SOLO UN ARTICULO
                case 4:

                    ArticulosRequisiciones::where('id', '=', $request->id)->update([
                        'EstatusArt' => 3,
                    ]);

                    //Reviso si hay articulos en Estatus de Solicitud para actualizarlos
                    $Solicitado = ArticulosRequisiciones::where('id', '=', $request->id)->where('EstatusArt', '=', 2)->count();

                    if($Solicitado == 0){
                        //Busco si hay un articulo en estatus de Cotizacion
                        $Cotizacion = ArticulosRequisiciones::where('id', '=', $request->id)->where('EstatusArt', '=', 3)->count();
                        //En caso de existir busco el id de la Requisicion a actualizar
                        if($Cotizacion > 0){
                            $Req = ArticulosRequisiciones::where('id', '=', $request->id)->first('requisicion_id');
                            //Actualizo es estatus de la requisicion a Cotizacion
                            Requisiciones::find($Req->requisicion_id)->update([
                                'Estatus' => 3,
                            ]);
                        }
                    }

                    return redirect()->back();
                    break;
                // CASO DE EXITENCIA DE UN SOLO PRODUCTO EN ALMACEN
                case 5:
                    //ACTUALIZO EL ARTICULO EN ALMACEN
                    ArticulosRequisiciones::where('id', '=', $request->id)->update([
                        'EstatusArt' => 8,
                    ]);

                    //OBTENGO EL ID DE LA REQUISICION
                    $Req = ArticulosRequisiciones::where('id', '=', $request->id)->first('requisicion_id');

                    //BUSCO SI EXISTE UN ARTICULO EN COTIZACION
                    $Cotizacion = Requisiciones::where('id', '=', $Req->requisicion_id)->where('Estatus', '=', 3)->count();

                    //EN CASO DE EXISTIR UN ARTICULO EN COTIZACION ACTUALIZO LA REQUISICION A COTIZACION
                    if($Cotizacion > 0){ //Existe un Articulo al menos que hay que cotizar
                        Requisiciones::find($Req->requisicion_id)->update([
                            'Estatus' => 3,
                        ]);
                        //EN CASO CONTRARIO QUE TODOS LOS ARTICULOS ESTEN EN ALMACEN ACTUALIZO LA REQUISICION A ALMACEN
                    }else{ //Todos los articulos pertenecientes a la requisicion tienen estatus 8
                        Requisiciones::find($Req->requisicion_id)->update([
                            'Estatus' => 8,
                        ]);
                    }

                    return redirect()->back();
                    break;
            }

        }
    }

}
