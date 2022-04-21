<?php

namespace App\Http\Controllers\Sistemas\Requisiciones;

use App\Http\Controllers\Controller;
use App\Models\Compras\Proveedores;
use App\Models\Compras\Requisiciones\Requisiciones;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use App\Models\Sistemas\Requisiciones\ArticulosRequisicionesSistemas;
use Illuminate\Support\Facades\Validator;
use App\Models\Sistemas\Requisiciones\CotizacionesSistemas;
use App\Models\Sistemas\Requisiciones\PreciosCotizacionesSistemas;
use App\Models\Sistemas\Requisiciones\ProveedoresSistemas;
use App\Models\Sistemas\Requisiciones\RequisicionesSistemas;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;

use function PHPUnit\Framework\isNull;

class CotizacionesSistemasController extends Controller{

    public function __construct(Departamentos $Dpto, PerfilesUsuarios $Per){
        $this->Dpto = $Dpto;
        $this->Per = $Per;
    }

    public function index(Request $request){
        $Session = auth()->user();

        //Asigna fecha dependiendo del request
        $hoy = Carbon::now();
        $request->Month == '' ? $mes = $hoy->format('n') : $mes = $request->Month;
        $request->Year == '' ? $anio = $hoy->format('Y') : $anio = $request->Year;

        //Catalogos
        $Departamentos = $this->Dpto->SelectDepartamentos();
        $Perfiles = PerfilesUsuarios::get(['id','IdUser','IdEmp', 'Nombre', 'ApPat','ApMat']);
        $ProveedoresSistemas = ProveedoresSistemas::get(['id', 'Nombre']);

        //Consultas para obtener costos de requisiciones Sistemas
        $CostosHLA = RequisicionesSistemas::CostosHLA($anio, $mes)->get();
        $CostosHilesa = RequisicionesSistemas::CostosHilesa($anio, $mes)->get();
        $CostoAñoHLA = RequisicionesSistemas::CostoAñoHLA($anio)->get();
        $CostoAñoHilesa = RequisicionesSistemas::CostoAñoHilesa($anio)->get();

        //Consulta Principal
        $RequisicionesSistemas = RequisicionesSistemas::with([
            'Perfil' => function($Perfil) { //Relacion 1 a 1 De puestos
                $Perfil->select('id', 'Nombre', 'ApPat', 'ApMat');
            },
            'Departamento' => function($Departamento) { //Relacion 1 a 1 De puestos
                $Departamento->select('id', 'Nombre');
            },
            'Articulos' => function($Articulos) { //Relacion 1 a 1 De puestos
                $Articulos->select('id', 'IdUser', 'Cantidad', 'Unidad', 'Dispositivo', 'requisicion_sistemas_id');
            },
        ])->where('Estatus', '>', 0)->get();

        if($request->Req){
            $RequisicionSistemas = RequisicionesSistemas::with(['Perfil','Departamento','Cotizacion.Proveedor','Cotizacion.Precios.Articulos'])->where('id', '=', $request->Req)->first();
        }else{
            $RequisicionSistemas = new stdClass();
        }

        return Inertia::render('Sistemas/Requisiciones/CotizacionesSistemas', compact('Session','Departamentos','Perfiles','ProveedoresSistemas','RequisicionesSistemas', 'RequisicionSistemas', 'CostosHLA', 'CostosHilesa', 'CostoAñoHLA', 'CostoAñoHilesa'));
    }

    public function store(Request $request){

        switch ($request->metodo) {
            case 1: //Caso para realizar Requisicion
                // return $request->Perfil_id;
                Validator::make($request->all(), [
                    'IdUser' => ['required'],
                    'Fecha' => ['required','date'],
                    'Estatus' => ['required'],
                    'Departamento_id' => ['required'],
                    'Partida.Cantidad.*' => ['required'],
                    'Partida.Unidad.*' => ['required'],
                    'Partida.Dispositivo.*' => ['required'],
                ])->validate();

                $CreaRequi = 0;
                $Session = auth()->user();
                $Perfil_id = PerfilesUsuarios::where('user_id','=',$request->IdUser)->first('id');
                //Genracion de folio automatico
                $Numfolio = RequisicionesSistemas::all(['Folio']);

                $hoy = Carbon::now();
                $anio = $hoy->format('y');

                $Nfolio = $Numfolio->last(); //Obtengo el ultimo folio con el metodo last
                if($Numfolio->count()){ //Verifico si hay folios
                    $AnioBd = substr($Nfolio->Folio, 0, 2); //Obtengo el año del folio

                    $serial = $Nfolio->Folio; //asigno el folio a la variable serial
                    $serial = substr($serial, 2); //Obtengo el folio sin el año

                    $AnioBd == $anio ?  $serial += 1 :  $serial = 1;
                }else{//Genero el Primer folio
                    $serial = 1;
                }

                foreach ($request->Partida as $value) { //Verifico que se envien datos en la partida
                    if( $value['Cantidad'] != '' && $value['Unidad'] != '' && $value['Dispositivo'] != ''){
                        $CreaRequi = 1;
                    }else{
                        $CreaRequi = 0;
                    }
                }

                if($CreaRequi == 1){ //Si hay datos en la partida se guardan

                    $Requisicion = RequisicionesSistemas::create([
                        'IdUser' => $request->IdUser,
                        'Fecha' => $request->Fecha,
                        'Folio' => $anio.$serial,
                        'Estatus' => 2,
                        'Perfil_id' => $request->Perfil_id,
                        'Departamento_id' => $request->Departamento_id,
                        'Comentarios' => $request->Comentarios,
                    ]);

                    $requisicion_id = $Requisicion->id;

                    foreach ($request->Partida as $value) {

                        ArticulosRequisicionesSistemas::create([
                            'IdUser' => $request->IdUser,
                            'Cantidad' => $value['Cantidad'],
                            'Unidad' => $value['Unidad'],
                            'Dispositivo' => $value['Dispositivo'],
                            'requisicion_sistemas_id' => $requisicion_id,
                        ]);
                    }

                }else{ //Caso contrario de manda un mensaje de Session
                    session()->flash('flash.type', 'Warning');
                    session()->flash('flash.message', 'Por favor Verifique la información capturada');
                }
                return redirect()->back();
                break;

            case 2: //Caso para Realizar Cotizacion de requisicion
                Validator::make($request->all(), [
                    'IdUser' => ['required'],
                    'Moneda' => ['required'],
                    'TipoPago' => ['required'],
                    'Proveedor_Sistemas_id' => ['required'],
                    // 'archivo' => ['mimes:jpg,png,jpeg,svg,pdf'],
                ])->validate();
                    // return $request;
                $CreaRequi = 0;
                $CostoTotal = 0;
                if(isset($request->archivo)){ //Valido envio de Archivo

                $file = $request->file("archivo")->getClientOriginalName(); //Obtengo el nombre del archivo y su extancion

                //Guardado de Imagen en la carpeta Public/Storage.. (Uso del disco Public pora la restriccion de los archivos)
                $url = $request->archivo->storePubliclyAs('Archivos/Sistemas/Requisiciones/Cotizaciones',  $file, 'public');

                }else{
                    $url = 'Archivos/FileNotFound404.jpg';
                }

                foreach ($request->DatosCotizacion as $value) { //Verifico que se envien datos en la partida
                    if( $value['Marca'] != '' && $value['PrecioUnitario'] != ''){
                        $CreaRequi = 1;
                    }else{
                        $CreaRequi = 0;
                    }
                }

                if($CreaRequi == 1){

                    $Cotizacion = CotizacionesSistemas::create([
                        'IdUser' => $request->IdUser,
                        'TipoPago' => $request->TipoPago,
                        'Moneda' => $request->Moneda,
                        'TipoCambio' => $request->TipoCambio,
                        'Aprobado' => 0,
                        'CostoExtra' => number_format($request->CostoExtra,2),
                        'Comentario' => $request->Comentario,
                        'Archivo' => $url,
                        'Proveedor_Sistemas_id' => $request->Proveedor_Sistemas_id,
                        'requisicion_sistemas_id' => $request->requisicion_sistemas_id,
                    ]);

                    $CostoTotal = number_format($request->CostoExtra,2); //Asigo el costoextra para sumarlo
                    $cotizacion_sistemas_id = $Cotizacion->id;

                    foreach ($request->DatosCotizacion as $value) {
                        $PrecioCotizacion = PreciosCotizacionesSistemas::create([
                            'IdUser' => $request->IdUser,
                            'Marca' => $value['Marca'],
                            'Precio' => number_format($value['PrecioUnitario'],2),
                            'Total' => number_format(($value['PrecioUnitario'] * $request->TipoCambio) * $value['Cantidad'],2),
                            'cotizacion_sistemas_id' => $cotizacion_sistemas_id,
                            'art_req_sistemas_id' => $value['id'],
                        ]);
                        //Suma los totales al costoExtra
                        $CostoTotal = $CostoTotal + ($value['PrecioUnitario'] * $request->TipoCambio) * $value['Cantidad'];
                    }

                    $CostoTotal = number_format($CostoTotal);

                    RequisicionesSistemas::where('id', $request->requisicion_sistemas_id)->update(['Estatus' => 3, 'CostoReq' => $CostoTotal]);

                }else{
                    session()->flash('flash.type', 'Warning');
                    session()->flash('flash.message', 'Por favor Verifique la información capturada');
                }

                return redirect()->back();
                break;
        }
    }

    public function update(Request $request, $id){

        switch ($request->Metodo) {
            case 1: //Confirma Cotizacion
                RequisicionesSistemas::where('id', $request->id)->update(['Estatus' => 4]);
                return redirect()->back();
                break;

            case 2: //Confirma Producto en existencia
                RequisicionesSistemas::where('id', $request->id)->update(['Estatus' => 6]);
                return redirect()->back();
                break;

            case 3: //Acutalizacion de la cotizacion
                if(isset($request->archivo)){ //Valido envio de Archivo
                    $file = $request->file("archivo")->getClientOriginalName(); //Obtengo el nombre del archivo y su extancion

                    //Guardado de Imagen en la carpeta Public/Storage.. (Uso del disco Public pora la restriccion de los archivos)
                    $url = $request->archivo->storePubliclyAs('Archivos/Sistemas/Requisiciones/Cotizaciones',  $file, 'public');

                    }else{
                        $url = 'Archivos/FileNotFound404.jpg';
                    }

                    $Cotizacion = CotizacionesSistemas::where('id', $request->Cotizacion_id)->update([
                        'IdUser' => $request->IdUser,
                        'TipoPago' => $request->TipoPago,
                        'Moneda' => $request->Moneda,
                        'TipoCambio' => $request->TipoCambio,
                        'Comentario' => $request->Comentario,
                        'Archivo' => $url,
                    ]);

                    foreach ($request->DatosCotizacion as $value) {

                        $PrecioCotizacion = PreciosCotizacionesSistemas::where('id', $value['Cot_id'])->update([
                            'Marca' => $value['Marca'],
                            'Precio' => $value['PrecioUnitario'],
                            'Total' => ($value['PrecioUnitario'] * $request->TipoCambio) * $value['Cantidad'],
                        ]);
                    }

                    return redirect()->back();
                break;
            case 4: //Cambia tipo de pago
                $Pago = CotizacionesSistemas::where('requisicion_sistemas_id', $request->id)->first('TipoPago');

                if($Pago->TipoPago == 'REM'){
                    CotizacionesSistemas::where('requisicion_sistemas_id', $request->id)->update(['TipoPago' => 'FAC']);
                }else{
                    CotizacionesSistemas::where('requisicion_sistemas_id', $request->id)->update(['TipoPago' => 'REM']);
                }
                return redirect()->back();
                break;
        }
    }

    public function destroy($id){
        //
    }
}
