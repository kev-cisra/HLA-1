<?php

namespace App\Http\Controllers\Compras\Insumos;

use App\Http\Controllers\Controller;
use App\Models\Compras\Insumos\Insumos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

use function PHPUnit\Framework\isNull;

class RequisicionInsumosController extends Controller{

    public function index(){

        $Session = auth()->user();

        if(count($Session->roles) != 0){
            $Rol = $Session->roles[0]->name;
        }else{
            $Rol = "SINROLASIGNADO";
        }

        if($Rol == 'ONEPIECE' || $Rol == 'Administrador'){
            $Insumos = Insumos::get();
        }else{
            $Insumos = Insumos::where('Departamento_id', '=', $Session->Departamento)->get();
        }


        return Inertia::render('Compras/Insumos/RequisicionInsumos', compact('Session', 'Insumos'));
    }
}
