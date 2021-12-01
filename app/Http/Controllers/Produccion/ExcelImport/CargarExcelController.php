<?php

namespace App\Http\Controllers\Produccion\ExcelImport;

use App\Http\Controllers\Controller;
use App\Imports\CargasImport;
use App\Models\Produccion\carNorm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $impo = Excel::import(new CargasImport, $request->file("file"));
        return redirect()->back()
            ->with('message', 'Post Created Successfully.');
    }
}
