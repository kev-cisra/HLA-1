<?php

namespace App\Http\Controllers\Menus;

use App\Http\Controllers\Controller;
use App\Models\Administrador\Modulos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class HilaturasController extends Controller{

    public function index(){

        $usuario = Auth::user();
        $modulos = Modulos::where("Area","=",10)->get();
        Cache::flush();
        return Inertia::render('Dashboard', compact('usuario', 'modulos'));
    }
}
