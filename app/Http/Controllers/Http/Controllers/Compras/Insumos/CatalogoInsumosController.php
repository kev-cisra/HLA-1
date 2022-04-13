<?php

namespace App\Http\Controllers\Compras\Insumos;

use App\Http\Controllers\Controller;
use App\Models\Compras\Insumos\Insumos;
use Illuminate\Http\Request;

class CatalogoInsumosController extends Controller{

    public function Dropdown(Request $request){
        //Recibe el parametro por medio del parametro de la vista
        $InsumoId = $request->input('Insumo');

        $data = Insumos::where('Departamento_id', $InsumoId)->get();

        return response()->json(["Insumos" => $data ]);
    }
}
