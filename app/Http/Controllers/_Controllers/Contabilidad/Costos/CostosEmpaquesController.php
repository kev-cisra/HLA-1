<?php

namespace App\Http\Controllers\Contabilidad\Costos;

use App\Http\Controllers\Controller;
use App\Models\Contabilidad\Costos\CostosEmpaques\CostosEmpaquesBolsas;
use App\Models\Contabilidad\Costos\CostosEmpaques\CostosEmpaquesConos;
use App\Models\Contabilidad\Costos\CostosEmpaques\CostosEmpaquesEtiquetasTermicas;
use App\Models\Contabilidad\Costos\CostosEmpaques\CostosEmpaquesLaminasCarton;
use App\Models\Contabilidad\Costos\CostosEmpaques\CostosEmpaquesRafia;
use Illuminate\Http\Request;
use Inertia\Inertia;
class CostosEmpaquesController extends Controller{

    public function index(Request $request){
        $Session = auth()->user();

        $Rafia = CostosEmpaquesRafia::get();
        $Etiquetas = CostosEmpaquesEtiquetasTermicas::get();
        $Bolsas = CostosEmpaquesBolsas::get();
        $LaminasCarton = CostosEmpaquesLaminasCarton::get();
        $Conos = CostosEmpaquesConos::get();

        return Inertia::render('Contabilidad/Costos/CostosEmpaques', compact('Session', 'Rafia', 'Etiquetas', 'Bolsas', 'LaminasCarton', 'Conos'));
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

        if($request->Material == 'RAFIA'){

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

        }elseif ($request->Material == 'ETIQUETA TERMICA') {

            $CostoEtiqueta = $Conversion / $request->Rollo;
            $KilosPorEtiqueta = round((260/0.75)*0.86, 3);
            $CostoUnitario = $CostoEtiqueta / $KilosPorEtiqueta;

            CostosEmpaquesEtiquetasTermicas::create([
                'Fecha' => $request->Fecha,
                'NumFactura' => $request->NumFactura,
                'Proveedor' => $request->Proveedor,
                'Concepto' => $request->Concepto,
                'Moneda' => $request->Moneda,
                'Importe' => $request->Importe,
                'TipoCambio' => $TipoCambio,
                'Conversion' => $Conversion,
                'Rollo' => $request->Rollo,
                'CostoEtiqueta' => $CostoEtiqueta,
                'KilosPorEtiqueta' => $KilosPorEtiqueta,
                'CostoUnitario' => $CostoUnitario,
            ]);
        }elseif ($request->Material == 'BOLSA POLIPAPEL') {

            $CostoBolsa = $Conversion / $request->BolsaPolipapel;
            $KilosPorBolsa = 28.5;
            $CostoUnitario = $CostoBolsa / $KilosPorBolsa;

            CostosEmpaquesBolsas::create([
                'Fecha' => $request->Fecha,
                'NumFactura' => $request->NumFactura,
                'Proveedor' => $request->Proveedor,
                'Concepto' => $request->Concepto,
                'Moneda' => $request->Moneda,
                'Importe' => $request->Importe,
                'TipoCambio' => $TipoCambio,
                'Conversion' => $Conversion,
                'Piezas' => $request->BolsaPolipapel,
                'CostoBolsa' => $CostoBolsa,
                'KilosPorBolsa' => $KilosPorBolsa,
                'CostoUnitario' => $CostoUnitario,
            ]);
        }elseif ($request->Material == 'LAMINA CARTON') {

            $CostoCarton = $Conversion / $request->LaminaCarton;
            $KilosPorCarton = 28.5;
            $CostoUnitario = $CostoCarton / $KilosPorCarton;

            CostosEmpaquesLaminasCarton::create([
                'Fecha' => $request->Fecha,
                'NumFactura' => $request->NumFactura,
                'Proveedor' => $request->Proveedor,
                'Concepto' => $request->Concepto,
                'Moneda' => $request->Moneda,
                'Importe' => $request->Importe,
                'TipoCambio' => $TipoCambio,
                'Conversion' => $Conversion,
                'Piezas' => $request->LaminaCarton,
                'CostoCarton' => $CostoCarton,
                'KilosPorCarton' => $KilosPorCarton,
                'CostoUnitario' => $CostoUnitario,
            ]);
        }elseif ($request->Material == 'CONO') {

            $CostoCono = $Conversion / $request->Cono;
            $KilosPorCono = 1.8;
            $CostoUnitario = $CostoCono / $KilosPorCono;

            CostosEmpaquesConos::create([
                'Fecha' => $request->Fecha,
                'NumFactura' => $request->NumFactura,
                'Proveedor' => $request->Proveedor,
                'Concepto' => $request->Concepto,
                'Moneda' => $request->Moneda,
                'Importe' => $request->Importe,
                'TipoCambio' => $TipoCambio,
                'Conversion' => $Conversion,
                'Piezas' => $request->Cono,
                'CostoCono' => $CostoCono,
                'KilosPorCono' => $KilosPorCono,
                'CostoUnitario' => $CostoUnitario,
            ]);
        }

        return redirect()->back();
    }

    public function update(Request $request, $id){

        return redirect()->back();
    }

    public function destroy($id){
    }
}
