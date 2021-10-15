<?php

namespace App\Http\Controllers\Direccion\Calculadora;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CalculadoraTorcionesController extends Controller{

    public function index(Request $request){
        $Session = auth()->user();
        return Inertia::render('Direccion/Calculadora/CalculadoraTorciones', compact('Session'));
    }
}
