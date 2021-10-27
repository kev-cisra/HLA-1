<?php

namespace App\Http\Controllers\Produccion\ExcelImport;

use App\Http\Controllers\Controller;
use App\Imports\CargasImport;
use App\Models\Produccion\dep_per;
use App\Models\Produccion\equipos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class CargarExcelController extends Controller
{
    //
    public function store(Request $request)
    {
        /* $dp = dep_per::join('perfiles_usuarios', 'perfiles_usuarios.id', 'dep_pers.perfiles_usuarios_id')->where('perfiles_usuarios.IdEmp', '=', 500)->first('dep_pers.id', 'AS', 'id');
        return $dp->id; */
        $equi = equipos::where('nombre', 'like', '%'.'equipo 1'.'%')->first('id');
        return equipos::where('nombre', 'like', '%'.'equipo 1'.'%')->first('id')->id;
        $impo = Excel::import(new CargasImport, $request->file("file"));
        return redirect()->back()
            ->with('message', 'Post Created Successfully.');
    }
}
