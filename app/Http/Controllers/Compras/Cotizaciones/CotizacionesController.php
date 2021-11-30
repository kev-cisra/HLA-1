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

        $Session = auth()->user();
        $hoy = Carbon::now();
        //Obtencion de filtros para Fechas
        $request->month == '' ? $mes = $hoy->format('n') : $mes = $request->month;
        $anio = 2021;

        //Obtengo el catalogo de proveedores
        $Proveedores = Proveedores::get();

        $ArticulosRequisicion = null;
        $ArticulosCotizar = null;
        $ArticulosPrecios = null;
        $Req = null;
        $Precio = null;
        $PreCount = null;
        $NumCot = null;

        /* ********************** CONSULTAS GENERALES************************ */

        //Consulta para vista de requisiciones
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
            ->get();

            //Consulta para vista por articulos
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
        ->where('EstatusArt', '>', 2)
        ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id']);


        if($request->Req != ''){ //Obtencion del id de la requisicion

            $Req = Requisiciones::where('id', '=', $request->Req)->get(); //Obtener el Num de requisicion
            //Cuento el numero de cotizaciones realizadas
            $NumCot = PreciosCotizaciones::where('NumCotizacion', '=', 2)->where('requisiciones_id', '=', $request->Req)->count();

            //Consulta para obtener las partidas relacionadas a esa requisicion
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

            //Consulta los articulos con sus precios correspondientes
            $ArticulosPrecios = ArticulosRequisiciones::with([
                'ArticuloPrecios' => function($pre) { //Relacion 1 a 1 De puestos
                    $pre->select('id', 'Precio', 'Total', 'Moneda', 'TipoCambio', 'Marca', 'Proveedor', 'Comentarios', 'Archivo', 'Autorizado', 'articulos_requisiciones_id', 'requisiciones_id');
                },
            ])
            ->where('requisicion_id', '=', $request->Req)
            ->get();

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
                $Precio = PreciosCotizaciones::where('articulos_requisiciones_id', '=', $request->Art)->get();
                $PreCount = PreciosCotizaciones::where('articulos_requisiciones_id', '=', $request->Art)->count();
            }

        }

        return Inertia::render('Compras/Cotizaciones/Cotizaciones', compact(
            'Session',
            'Req', //Numero de requisicion
            'NumCot', //Numero de cotizaciones realizadas
            'Precio', //Obtengo los precios relacionados al articulo
            'PreCount',
            'Proveedores',
            'Requisiciones',
            'ArticulosRequisiciones',
            'ArticulosRequisicion',
            'ArticulosCotizar',
            'ArticulosPrecios',
        ));
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

                if($request->Moneda == 'MXN'){ //Obtengo el tipo de moneda
                    $Total = $value['PrecioUnitario'] * $value['Cantidad']; //Calculo el total
                    $Total = number_format($Total);
                    $TipoCambio = 0;
                }else{
                    $TipoCambio = $request->TipoCambio;
                    $Total1 = round($value['PrecioUnitario'] * $request->TipoCambio, 2); //Calculo el total del Precio Unitario
                    $Total = $Total1 * $value['Cantidad']; //Calculo el otal del la cotizacion
                    $Total = number_format($Total);
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
                    'Precio' => number_format($value['PrecioUnitario']),
                    'Total' => $Total ,
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
                    $Precio = PreciosCotizaciones::find($request->IdPre)->first();
                    $url = $Precio->archivo;
                }

                //Actualizacion de datos
                PreciosCotizaciones::find($request->IdPre)->update([
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

                //Caluclo de segundo precio cotizado
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
                        'Archivo' => $url,
                    ]);
                }
                break;
            }

            //Envio de cotizacion a autorizacion
            case 2:{
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

            //Agregar comentario de fecha de llegada
            case 3:{

                ArticulosRequisiciones::where('requisicion_id', '=', $request->IdArt)->update([
                    'Fechallegada' => $request->Fechallegada,
                    'Comentariollegada' => $request->Comentariollegada,
                    'EstatusArt' => 7,
                ]);

                Requisiciones::find($request->IdArt)->update([
                    'Estatus' => 7,
                ]);

                TiemposRequisiciones::where('articulo_requisicion_id', '=', $request->IdArt)->update([
                    'Confirmado' => Carbon::now(),
                ]);

                break;
            }
        }

        return redirect()->back();

    }
}
