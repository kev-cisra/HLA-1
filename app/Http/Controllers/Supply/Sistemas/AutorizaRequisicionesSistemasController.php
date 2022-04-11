<?php

namespace App\Http\Controllers\Supply\Sistemas;

use App\Http\Controllers\Controller;
use App\Models\Sistemas\Requisiciones\CotizacionesSistemas;
use App\Models\Sistemas\Requisiciones\PreciosCotizacionesSistemas;
use App\Models\Sistemas\Requisiciones\RequisicionesSistemas;
use Illuminate\Http\Request;
use Inertia\Inertia;
use stdClass;

class AutorizaRequisicionesSistemasController extends Controller{

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
                $Articulos->select('id', 'IdUser', 'Cantidad', 'Unidad', 'Dispositivo', 'requisicion_sistemas_id');
            }
        ])->where('Estatus', '>=', 3)->get();

        if($request->Req){
            $RequisicionSistemas = RequisicionesSistemas::with(['Perfil','Departamento','Cotizacion.Precios.Articulos'])->where('id', '=', $request->Req)->first();

        }else{
            $RequisicionSistemas = new stdClass();
        }

        return Inertia::render('Supply/Sistemas/AutorizaCotizaciones', compact('Session', 'RequisicionesSistemas', 'RequisicionSistemas'));
    }

    public function update(Request $request, $id){

        switch ($request->Metodo) {
            case 1: //Caso de Autorizacion de cotizacion
                //Actualiza el estauts de la requisicion
                RequisicionesSistemas::where('id', $request->requisicion_sistemas_id)->update(['Estatus' => 4]);
                //Rechaza todas las cotizaciones
                CotizacionesSistemas::where('requisicion_sistemas_id', $request->requisicion_sistemas_id)->update(['Aprobado' => 0]);
                //Autorizar la cotizacion seleccionada
                CotizacionesSistemas::where('id', $request->id)->update(['Aprobado' => 1]);
                return redirect()->back();
                break;

            case 2:
                    //Actualiza el estauts de la requisicion rechazada
                    RequisicionesSistemas::where('id', $request->requisicion_sistemas_id)->update(['Estatus' => 10]);
                    //Rechaza la cotizacion seleccionada
                    CotizacionesSistemas::where('id', $request->id)->update(['Aprobado' => 0]);
                return redirect()->back();
                    return redirect()->back();
                break;
        }
    }
}