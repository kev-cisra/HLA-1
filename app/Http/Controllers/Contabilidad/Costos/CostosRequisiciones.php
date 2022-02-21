<?php

namespace App\Http\Controllers\Contabilidad\Costos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CostosRequisiciones extends Controller{

    public function index(Request $request){

        return Inertia::render('Contabilidad/Costos/CostosRequisiciones');
    }

}
