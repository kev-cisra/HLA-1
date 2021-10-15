<?php

namespace App\Http\Controllers\Compras\Insumos;

use App\Http\Controllers\Controller;
use App\Models\Compras\Insumos\Insumos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class RequisicionInsumosController extends Controller{

    public function index(){

        $Session = auth()->user();

        $Insumos = Insumos::get();

        return Inertia::render('Compras/Insumos/RequisicionInsumos', compact('Session', 'Insumos'));
    }
}
