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

use function PHPUnit\Framework\isNull;

class CotizacionesController extends Controller{

    public function index(Request $request){

        $hoy = Carbon::now();
        $anio = 2021;

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
                ->where('Estatus', '>', 2)
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
                ->where('Estatus', '>', 2)
                ->whereYear('Fecha', $anio)
                ->where('Estatus', $request->Estatus)
                ->get();
        }

        if($request->Req != ''){
            $ArticulosRequisiciones = ArticulosRequisiciones::where('requisicion_id','=', $request->Req)->get();
            $PreciosRequisicion = PreciosCotizaciones::where('requisiciones_id', '=', $request->Req)->get();
        }else{
            $ArticulosRequisiciones = null;
            $PreciosRequisicion = null;
        }

        if($request->Cot != ''){
            $PreciosCotizacion = PreciosCotizaciones::with('PreciosArticulo')->where('articulos_requisiciones_id','=', $request->Cot)->get();
        }else{
            $PreciosCotizacion = PreciosCotizaciones::with('PreciosArticulo')->get();
        }


        $Almacen = Requisiciones::where('Estatus', '=', 8)->count();

        $Cotizacion = Requisiciones::where('Estatus', '=', 3)->count();

        $SinConfirmar = Requisiciones::where('Estatus', '=', 5)->count();

        $Autorizados = Requisiciones::where('Estatus', '=', 5)->count();

        $Confirmar = Requisiciones::where('Estatus', '=', 6)->count();

        $Precios = Requisiciones::with('ArticuloPrecios')->get();


        return Inertia::render('Compras/Cotizaciones/Cotizaciones', compact(
            'Session',
            'PerfilesUsuarios',
            'Requisiciones',
            'ArticulosRequisiciones',
            'PreciosCotizacion',
            'PreciosRequisicion',
            'Precios',
            'Proveedores',
            'Almacen',
            'Cotizacion',
            'SinConfirmar',
            'Confirmar',
            'Autorizados',
            'mes'));
    }

    public function store(Request $request){

        if(isset($request)){ //Verifico la existencia de datos

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

                if($request->Moneda == 'MXN'){
                    $Total = $value['PrecioUnitario'] * $value['Cantidad'];
                }else{
                    $Total1 = round($value['PrecioUnitario'] * $request->TipoCambio, 2);
                    $Total = $Total1 * $value['Cantidad'];
                }


                $Cotizacion = PreciosCotizaciones::create([
                    'IdUser' => $request->IdUser,
                    'Precio' => $value['PrecioUnitario'],
                    'Total' => $Total ,
                    'Moneda' => $request->Moneda,
                    'TipoCambio' => $request->TipoCambio,
                    'Marca' => $request->Marca,
                    'Proveedor' => $request->Proveedor,
                    'Comentarios' => $request->Comentarios,
                    'Archivo' => $url,
                    'articulos_requisiciones_id' => $value['IdArt'],
                    'requisiciones_id' => $value['requisicion_id'],
                ]);

                Requisiciones::where('id', '=', $value['requisicion_id'])->update([
                    'Estatus' => 4,
                ]);

                ArticulosRequisiciones::where('id', '=', $value['IdArt'])->update([
                    'EstatusArt' => 4,
                ]);
            }

            $NumCotizaciones = PreciosCotizaciones::where('requisiciones_id', '=', $value['requisicion_id'])->count();

            if($NumCotizaciones == 1){
                PreciosCotizaciones::find($Cotizacion->id)->update([
                    'NumCotizacion' => 1,
                ]);
            }else{
                PreciosCotizaciones::find($Cotizacion->id)->update([
                    'NumCotizacion' => $NumCotizaciones,
                ]);
            }

            return redirect()->back();

        }else{
            return "Ocurrio un Error Intente nuevamente";
        }

    }

    public function update(Request $request, $id){


        switch($request->metodo){
            case 0:{
                $Session = auth()->user();

                if(isset($request->archivo)){

                    Validator::make($request->all(), [
                        'archivo' => 'required|mimes:jpg,png,jpeg,svg,pdf',
                    ])->validate();

                    $file = $request->file("archivo")->getClientOriginalName(); //Obtengo el nombre del archivo y su extancion

                    //Guardado de Imagen en la carpeta Public/Storage.. (Uso del disco Public pora la restriccion de los archivos)
                    $url = $request->archivo->storePubliclyAs('Archivos/Compras/Requisiciones/Cotizaciones',  $file, 'public');
                }else{
                    $url = 'Archivos/FileNotFound404.jpg';
                }

                PreciosCotizaciones::find($request->IdPre)->update([

                    'IdUser' => $request->IdUser,
                    'Precio' => $request->Precio,
                    'Total' => $request->Total,
                    'Moneda' => $request->Moneda,
                    'TipoCambio' => $request->TipoCambio,
                    'Marca' => $request->Marca,
                    'Proveedor' => $request->Proveedor,
                    'Comentarios' => $request->Comentarios,
                    'Archivo ' => $url,
                    'NombreProveedor' => $request->NombreProveedor
                ]);

                break;
            }

            case 5:{

                ArticulosRequisiciones::where('requisicion_id', '=', $request->id)->update([
                    'EstatusArt' => 5,
                ]);

                Requisiciones::find($request->id)->update([
                    'Estatus' => 5,
                ]);

                TiemposRequisiciones::where('articulo_requisicion_id', '=', $request->id)->update([
                    'Cotizado' => Carbon::now(),
                ]);

                break;
            }

            case 7:{

                ArticulosRequisiciones::find($request->IdArt)->update([
                    'Fechallegada' => $request->Fechallegada,
                    'Comentariollegada' => $request->Comentariollegada,
                    'EstatusArt' => 7,
                ]);

                TiemposRequisiciones::where('articulo_requisicion_id', '=', $request->IdArt)->update([
                    'Confirmado' => Carbon::now(),
                ]);

                break;
            }

            case 8: {
                $Session = auth()->user();

                if($request->Moneda == 'MXN'){
                    $Total = $request->Precio * $request->Cantidad;
                }else{
                    $Total1 = round($request->Precio * $request->TipoCambio, 2);
                    $Total = $Total1 * $request->Cantidad;
                }

                if(isset($request->archivo)){

                    Validator::make($request->all(), [
                        'archivo' => 'required|mimes:jpg,png,jpeg,svg,pdf',
                    ])->validate();

                    $file = $request->file("archivo")->getClientOriginalName(); //Obtengo el nombre del archivo y su extancion

                    //Guardado de Imagen en la carpeta Public/Storage.. (Uso del disco Public pora la restriccion de los archivos)
                    $url = $request->archivo->storePubliclyAs('Archivos/Compras/Requisiciones/Cotizaciones',  $file, 'public');
                }else{
                    $Precio = PreciosCotizaciones::find($request->IdPre)->first();
                    $url = $Precio->Archivo;
                }

                PreciosCotizaciones::find($request->IdPre)->update([
                    'IdUser' => $request->IdUser,
                    'Precio' => $request->Precio,
                    'Total' => $Total,
                    'Moneda' => $request->Moneda,
                    'TipoCambio' => $request->TipoCambio,
                    'Marca' => $request->Marca,
                    'Proveedor' => $request->Proveedor,
                    'Comentarios' => $request->Comentarios,
                    'Archivo ' => $url,
                ]);

                if(isset($request->IdPre2) != ''){

                    if($request->Moneda == 'MXN'){
                        $Total2 = $request->Precio2 * $request->Cantidad;
                    }else{
                        $Total1 = round($request->Precio2 * $request->TipoCambio, 2);
                        $Total2 = $Total1 * $request->Cantidad;
                    }

                    PreciosCotizaciones::find($request->IdPre2)->update([
                        'IdUser' => $request->IdUser,
                        'Precio' => $request->Precio2,
                        'Total' => $Total2,
                        'Moneda' => $request->Moneda,
                        'TipoCambio' => $request->TipoCambio,
                        'Marca' => $request->Marca,
                        'Proveedor' => $request->Proveedor,
                        'Comentarios' => $request->Comentarios,
                        'Archivo ' => $url,
                    ]);
                }

            }
        }

        return redirect()->back();

    }
}
