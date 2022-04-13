<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\MarcasMaquinas;
use Illuminate\Http\Request;

class MarcasController extends Controller
{
    public function Dropdown(Request $request){

        $MaquinaId = $request->input('Maquina');

        $data = MarcasMaquinas::where('maquinas_id', $MaquinaId)->get();

        return response()->json(["Marcas" => $data ]);
    }
}
