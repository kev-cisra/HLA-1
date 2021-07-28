<?php

namespace App\Http\Controllers\Menus;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MenuProducccionController extends Controller
{
    //
    public function index() {
        $usuario = Auth::user();
        return Inertia::render('Produccion/index', ['usuario' => $usuario]);
    }
}
