<?php

namespace App\Http\Controllers\Sistemas\Requisiciones;

use App\Http\Controllers\Controller;
use App\Models\Sistemas\Requisiciones\CotizacionesSistemas;
use App\Models\Sistemas\Requisiciones\PreciosCotizacionesSistemas;
use App\Models\Sistemas\Requisiciones\RequisicionesSistemas;
use Illuminate\Http\Request;
use Inertia\Inertia;
use stdClass;

use function PHPUnit\Framework\isNull;

class CotizacionesSistemasController extends Controller{

    public function index(Request $request){
        $Session = auth()->user();

        $RequisicionesSistemas = RequisicionesSistemas::with([
            'Perfil' => function($Perfil) { //Relacion 1 a 1 De puestos
                $Perfil->select('id', 'Nombre', 'ApPat', 'ApMat');
            },
            'Departamento' => function($Departamento) { //Relacion 1 a 1 De puestos
                $Departamento->select('id', 'Nombre');
            },
            'Articulos' => function($Articulos) { //Relacion 1 a 1 De puestos
                $Articulos->select('id', 'IdUser', 'Cantidad', 'Unidad', 'Hardware_id', 'requisicion_sistemas_id');
            },
            'Articulos.Hardware' => function($Articulos) { //Relacion 1 a 1 De puestos
                $Articulos->select('id', 'IdUser', 'Cantidad', 'Nombre', 'Marca', 'Modelo');
            },
        ])->where('Estatus', '>', 0)->get();

        if($request->Req){
            $RequisicionSistemas = RequisicionesSistemas::with(['Perfil','Departamento','Cotizacion.Precios.Articulos.Hardware'])->where('id', '=', $request->Req)->first();
        }else{
            $RequisicionSistemas = new stdClass();
        }

        return Inertia::render('Sistemas/Requisiciones/CotizacionesSistemas', compact('Session', 'RequisicionesSistemas', 'RequisicionSistemas'));
    }

    public function store(Request $request){
        // return $request;
        if(isset($request->archivo)){ //Valido envio de Archivo

        $file = $request->file("archivo")->getClientOriginalName(); //Obtengo el nombre del archivo y su extancion

        //Guardado de Imagen en la carpeta Public/Storage.. (Uso del disco Public pora la restriccion de los archivos)
        $url = $request->archivo->storePubliclyAs('Archivos/Sistemas/Requisiciones/Cotizaciones',  $file, 'public');

        }else{
            $url = 'Archivos/FileNotFound404.jpg';
        }

        $Cotizacion = CotizacionesSistemas::create([
            'IdUser' => $request->IdUser,
            'TipoPago' => $request->TipoPago,
            'Moneda' => $request->Moneda,
            'TipoCambio' => $request->TipoCambio,
            'Aprobado' => 0,
            'Comentario' => $request->Comentario,
            'Archivo' => $url,
            'requisicion_sistemas_id' => $request->requisicion_sistemas_id,
        ]);

        $cotizacion_sistemas_id = $Cotizacion->id;

        foreach ($request->DatosCotizacion as $value) {

            $PrecioCotizacion = PreciosCotizacionesSistemas::create([
                'IdUser' => $request->IdUser,
                'Marca' => $value['Marca'],
                'Precio' => $value['PrecioUnitario'],
                'Total' => ($value['PrecioUnitario'] * $request->TipoCambio) * $value['Cantidad'],
                'cotizacion_sistemas_id' => $cotizacion_sistemas_id,
                'art_req_sistemas_id' => $value['id'],
            ]);
        }

        RequisicionesSistemas::where('id', $request->requisicion_sistemas_id)->update(['Estatus' => 2]);

        return redirect()->back();

    }

    public function update(Request $request, $id){

        switch ($request->Metodo) {
            case 1:
                RequisicionesSistemas::where('id', $request->id)->update(['Estatus' => 3]);
                return redirect()->back();
                break;

            case 2:
                RequisicionesSistemas::where('id', $request->id)->update(['Estatus' => 5]);
                return redirect()->back();
                break;

            case 3: //Atualizacion de la cotizacion
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
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
