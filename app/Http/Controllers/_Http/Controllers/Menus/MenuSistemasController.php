<?php

namespace App\Http\Controllers\Menus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
class MenuSistemasController extends Controller{

    public function index(){

        return Inertia::render('Menus/Sistemas');
    }
}
