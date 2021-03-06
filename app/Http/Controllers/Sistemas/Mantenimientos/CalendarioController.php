<?php

namespace App\Http\Controllers\Sistemas\Mantenimientos;

use App\Http\Controllers\Controller;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use App\Models\Sistemas\Hardware\HardwareAsignado;
use App\Models\Sistemas\Mantenimientos\CalendarioMantenimientos;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class CalendarioController extends Controller{

    public function Eventos(Request $request) {

        $date = Carbon::now();
        $year = $date->format('Y');

        if(isset($request->busca)){
            $Session = Auth::user();
            $User = User::find($Session->id); //Accedo a los datos del usuario logueado
            $Perfil = PerfilesUsuarios::where('User_id', $Session->id)->first('id');
            $Autorizado = $User->hasAnyRole(['ONEPIECE', 'Administrador', 'Sistemas']); //Busco si el suaurio tiene alguno de los siguientes Roles
            if($Autorizado == 1){
                return CalendarioMantenimientos::whereYear('start', $year)->get();
            }else{
                return CalendarioMantenimientos::whereYear('start', $year)->where('Perfil_id', '=', $Perfil->id)->get();
            }
        }
    }

}
