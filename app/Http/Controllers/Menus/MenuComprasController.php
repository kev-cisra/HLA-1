<?php

namespace App\Http\Controllers\Menus;

use App\Http\Controllers\Controller;
use App\Models\Administrador\Modulos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
class MenuComprasController extends Controller
{
    public function index() {

        $User = Auth::user();
        $modulos = Modulos::where("Area","=","4")->get();

        return Inertia::render('Menus/Compras',compact('User'));
    }
}
