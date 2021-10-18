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
            $Insumos = Insumos::where('Departamento_id', '=', 8)->get(['id', 'IdUser', 'Nombre', 'Unidad', 'Departamento_id']);
            $NumInsumos = Insumos::where('Departamento_id', '=', 8)->count();
        }else{
            $Insumos = Insumos::where('Departamento_id', '=', $Session->Departamento)->get(['id', 'IdUser', 'Nombre', 'Unidad', 'Departamento_id']);
            $NumInsumos = Insumos::where('Departamento_id', '=', 8)->count();
        }

        return Inertia::render('Compras/Insumos/RequisicionInsumos', compact('Session', 'Insumos', 'NumInsumos'));
    }

    public function store(Request $request){

        return $request;

        return redirect()->back();
    }
}
