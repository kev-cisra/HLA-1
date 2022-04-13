<?php

namespace App\Http\Controllers\Menus;

use App\Http\Controllers\Controller;
use App\Models\Administrador\Modulos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
class MenuRecursosHumanosController extends Controller{

    public function index(){

        $usuario = Auth::user();
        $modulos = Modulos::where("Area","=",2)->get();
        return Inertia::render('Menus/RecursosHumanos', compact('usuario', 'modulos'));
    }
}
