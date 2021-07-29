<?php

namespace App\Http\Controllers\Menus;

use App\Http\Controllers\Controller;
use App\Models\Administrador\Modulos;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MenuProducccionController extends Controller
{
    //
    public function index() {
        $usuario = Auth::user();
        $modelos = Modulos::where("Area","=","7")->get();
        return Inertia::render('Menus/Produccion', ['usuario' => $usuario,'modelos' => $modelos]);
    }
}
