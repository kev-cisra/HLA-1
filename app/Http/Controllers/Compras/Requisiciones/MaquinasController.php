<?php

namespace App\Http\Controllers\Compras\Requisiciones;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\Maquinas;
use Illuminate\Http\Request;

class MaquinasController extends Controller
{
    public function Dropdown(Request $request){

        $DeptoId = $request->input('Departamento_id');

        return $data = Maquinas::where('departamento_id', $DeptoId)->get();

        return response()->json(["Maquinas" => $data ]);
    }
}
