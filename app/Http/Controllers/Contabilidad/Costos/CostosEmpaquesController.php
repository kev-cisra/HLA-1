<?php

namespace App\Http\Controllers\Contabilidad\Costos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CostosEmpaquesController extends Controller{

    public function index(Request $request){
        $Session = auth()->user();
        return Inertia::render('Contabilidad/Costos/CostosEmpaques', compact('Session'));
    }
}
