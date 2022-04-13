<?php

namespace App\Http\Controllers\Almacen\Requisiciones;

use App\Http\Controllers\Controller;
use App\Models\Almacen\Requisiciones\ValesSalida;
use App\Models\Compras\Proveedores;
use App\Models\Compras\Requisiciones\Requisiciones;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ValesSalidaController extends Controller{

    public function index(Request $request){

        $Session = auth()->user(); //Obtengo el Usuario logueado

        //Catalogos
        $Proveedores = Proveedores::get(['id','Nombre']);

        //Consulta Principal
        $ValesSalida = ValesSalida::with(['Requisicion', 'Requisicion.RequisicionArticulos'])->get();

        return Inertia::render('Almacen/Requisiciones/ValesSalida', compact('Session', 'Proveedores', 'ValesSalida'));
    }

    public function store(Request $request){

        $Session = auth()->user(); //Obtengo el Usuario logueado

        Validator::make($request->all(), [
            'NumReq' => ['required'],
            'Folio' => ['required'],
            'Fecha' => ['required'],
            'NombreProveedor' => ['required'],
            'EstatusVale' => ['required'],
        ])->validate();

        $Req = Requisiciones::where('NumReq', '=', $request->NumReq)->first(['id','NumReq']);

        ValesSalida::create([
            'IdUser' => $Session->id,
            'IdEmp' => $Session->IdEmp,
            'Folio' => $request->Folio,
            'Fecha' => $request->Fecha,
            'NombreProveedor' => $request->NombreProveedor,
            'EstatusVale' => $request->EstatusVale,
            'Salida' => $request->Salida,
            'requisiciones_id' => $Req->id,
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id){

        $Session = auth()->user(); //Obtengo el Usuario logueado
        $Req = Requisiciones::where('NumReq', '=', $request->NumReq)->first(['id','NumReq']);

        ValesSalida::where('id', '=', $id)->update([
            'IdUser' => $Session->id,
            'IdEmp' => $Session->IdEmp,
            'Folio' => $request->Folio,
            'Fecha' => $request->Fecha,
            'NombreProveedor' => $request->NombreProveedor,
            'EstatusVale' => $request->EstatusVale,
            'Salida' => $request->Salida,
            'requisiciones_id' => $Req->id,
        ]);

        return redirect()->back();
    }


    public function destroy($id){

        if (isset($id)) {
            ValesSalida::find($id)->delete();
            return redirect()->back();
        }
    }
}
