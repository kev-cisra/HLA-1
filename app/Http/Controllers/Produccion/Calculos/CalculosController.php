<?php

namespace App\Http\Controllers\Produccion\Calculos;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalculosController extends Controller
{
    //
    public function store(Request $request)
    {
        //
        $hoy = Carbon::now();
        return $request;

        /* return redirect()->back()
            ->with('message', 'Post Created Successfully.'); */
    }
}
