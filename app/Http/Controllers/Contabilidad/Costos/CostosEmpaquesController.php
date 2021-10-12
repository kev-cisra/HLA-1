<?php

namespace App\Http\Controllers\Contabilidad\Costos;

use App\Http\Controllers\Controller;
use App\Models\Contabilidad\Costos\CostosEmpaques\CostosEmpaquesRafia;
use Illuminate\Http\Request;
use Inertia\Inertia;
class CostosEmpaquesController extends Controller{

    public function index(Request $request){
        $Session = auth()->user();

        $Rafia = CostosEmpaquesRafia::get();

        return Inertia::render('Contabilidad/Costos/CostosEmpaques', compact('Session', 'Rafia'));
    }

    public function store(Request $request){

        $Session = auth()->user();

        if($request->Moneda == 'USD'){
            $TipoCambio = $request->TipoCambio;
            $Conversion = $request->Conversion;
        }else{
            $TipoCambio = 0;
            $Conversion = $request->Importe;
        }

        $Costo100G = $Conversion / 1000*100;
        $KilosPorBorra = $Costo100G / 250;
        $CostoUnitario = $KilosPorBorra / $Costo100G;

        CostosEmpaquesRafia::create([
            'Fecha' => $request->Fecha,
            'NumFactura' => $request->NumFactura,
            'Proveedor' => $request->Proveedor,
            'Concepto' => $request->Concepto,
            'Moneda' => $request->Moneda,
            'Importe' => $request->Importe,
            'TipoCambio' => $TipoCambio,
            'Conversion' => $Conversion,
            'ImporteKilo' => $request->ImporteKilo,
            'Costo100G' => $Costo100G,
            'KilosPorBorra' => $KilosPorBorra,
            'CostoUnitario' => $CostoUnitario,
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id){

        return redirect()->back();
    }

    public function destroy($id){

    }
}
