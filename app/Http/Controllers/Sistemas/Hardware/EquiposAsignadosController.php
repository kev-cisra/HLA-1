<?php

namespace App\Http\Controllers\Sistemas\Hardware;

use App\Http\Controllers\Controller;
use App\Models\Sistemas\Hardware\HardwareSistemas;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EquiposAsignadosController extends Controller{

    public function index(){
        $Session = auth()->user();
        $EquiposAsignados = HardwareSistemas::get();
        return Inertia::render('Sistemas/Equipos/EquiposAsignados', compact('Session', 'EquiposAsignados'));
    }
}
