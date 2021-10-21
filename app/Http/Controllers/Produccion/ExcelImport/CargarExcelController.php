<?php

namespace App\Http\Controllers\Produccion\ExcelImport;

use App\Http\Controllers\Controller;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CargarExcelController extends Controller
{
    //
    public function store(Request $request)
    {
        return $request;
/*         $usuario = Auth::id();
        $perf = PerfilesUsuarios::where('user_id','=',$usuario)
            ->first('id'); */
        echo $request;
    }
}
