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

class CotizacionesController extends Controller{

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
                'ArticuloUser' => function($perfil) { //Relacion 1 a 1 De puestos
                    $perfil->select('id', 'name');
                },
                'ArticuloPrecios' => function($pre) { //Relacion 1 a 1 De puestos
                    $pre->select('id', 'Precio', 'Total', 'Moneda', 'TipoCambio','Marca', 'Proveedor', 'Comentarios', 'Archivo', 'Autorizado', 'articulos_requisiciones_id', 'requisiciones_id');
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
            ->where('EstatusArt', '!=', 1)
            ->where('EstatusArt','!=', 2)
            ->whereMonth('Fecha', $mes)
            ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'MotivoRechazo', 'Resguardo', 'OrdenCompra', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id']);

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
                'ArticuloUser' => function($perfil) { //Relacion 1 a 1 De puestos
                    $perfil->select('id', 'name');
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
            ->where('EstatusArt', '!=', 1)
            ->where('EstatusArt','!=', 2)
            ->where('EstatusArt', $request->Estatus)
            ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'MotivoCancelacion', 'MotivoRechazo', 'Resguardo', 'Fechallegada',  'OrdenCompra', 'Comentariollegada', 'RecibidoPor', 'requisicion_id']);

        }

        if($request->Cot != ''){
            $PreciosCotizacion = PreciosCotizaciones::with('PreciosArticulo')->where('articulos_requisiciones_id','=', $request->Cot)->get();
        }else{
            $PreciosCotizacion = PreciosCotizaciones::with('PreciosArticulo')->get();
        }

        $pru = Requisiciones::with(['RequisicionArticulos', 'RequisicionesPerfil', 'RequisicionDepartamento', 'RequisicionJefe', 'RequisicionMaquina', 'RequisicionMarca'])->get();

        if($request->Req != ''){
            $Art = ArticulosRequisiciones::where('requisicion_id','=', $request->Req)->get();
            $CantidadArt = ArticulosRequisiciones::where('requisicion_id','=', $request->Req)->count();
            $PreciosRequisicion = PreciosCotizaciones::where('requisiciones_id', '=', $request->Req)->get();
        }else{
            $Art = null;
            $CantidadArt = 0;
        }

        $Almacen = ArticulosRequisiciones::where('EstatusArt', '=', 8)->count();

        $Cotizacion = ArticulosRequisiciones::where('EstatusArt', '=', 3)->count();

        $SinConfirmar = ArticulosRequisiciones::where('EstatusArt', '=', 5)->count();

        $Autorizados = ArticulosRequisiciones::where('EstatusArt', '=', 5)->count();

        $Confirmar = ArticulosRequisiciones::where('EstatusArt', '=', 6)->count();

        $Precios = ArticulosRequisiciones::with('ArticuloPrecios')->get();


        return Inertia::render('Compras/Cotizaciones/Cotizaciones', compact(
            'Session',
            'PerfilesUsuarios',
            'ArticuloRequisicion',
            'PreciosCotizacion',
            'Precios',
            'Proveedores',
            'Almacen',
            'Cotizacion',
            'SinConfirmar',
            'Confirmar',
            'Autorizados',
            'mes',
            'pru', 'Art', 'CantidadArt', 'PreciosRequisicion'));
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


                PreciosCotizaciones::create([
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

                ArticulosRequisiciones::find($request->id)->update([
                    'EstatusArt' => 5,
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
        }

        return redirect()->back();

    }
}
