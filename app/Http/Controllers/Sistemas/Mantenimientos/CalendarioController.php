<?php

namespace App\Http\Controllers\Sistemas\Mantenimientos;

use App\Http\Controllers\Controller;
use App\Models\Sistemas\Hardware\HardwareAsignado;
use App\Models\Sistemas\Mantenimientos\CalendarioMantenimientos;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
class CalendarioController extends Controller{

    public function Eventos(Request $request) {

        if(isset($request->busca)){
            return CalendarioMantenimientos::where('Hardware_id', '=', $request->busca)->get();
        }
    }
}
