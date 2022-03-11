<?php

namespace App\Http\Controllers\Produccion\ExcelImport;

use App\Http\Controllers\Controller;
use App\Imports\CargasImport;
use App\Imports\CargasOpenImport;
use App\Imports\MatrizObjeImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class CargarExcelController extends Controller
{
    //
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'file' => ['required']
        ])->validate();
        //$impo = Excel::import(new CargasImport, $request->file("file"));
        return redirect()->back()
            ->with('message', 'Post Created Successfully.');
    }

    public function impoMatriz(Request $request)
    {
        Validator::make($request->all(), [
            'file' => ['required']
        ])->validate();
        return $request;

        //Excel::import(new MatrizObjeImport, $request->file("file"));
        Excel::import(new CargasOpenImport, $request->file("file"));
        return "listo";
    }



}
