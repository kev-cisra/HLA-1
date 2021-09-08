<?php

namespace App\Http\Controllers\Almacen\Requisiciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class RequisicionesSolicitadasController extends Controller {

    public function index(){  

        // $Session = Auth::user();
        $Session = auth()->user();


        return Inertia::render('Almacen/Requisiciones/Requisiciones', compact('Session'));
    }
}
