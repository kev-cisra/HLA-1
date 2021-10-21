<?php

namespace App\Http\Controllers\Compras\Requisiciones;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\Maquinas;
use App\Models\Catalogos\MarcasMaquinas;
use Illuminate\Http\Request;

class MaquinasController extends Controller
{
    public function Dropdown(Request $request){

        $MaquinaId = $request->input('Departamento');

        $data = Maquinas::where('departamento_id', $MaquinaId)->get();

        return response()->json(["Marcas" => $data ]);
    }
}
