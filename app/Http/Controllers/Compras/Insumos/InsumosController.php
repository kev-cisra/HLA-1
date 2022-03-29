<?php

namespace App\Http\Controllers\Compras\Insumos;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Compras\Insumos\Insumos;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InsumosController extends Controller{

    public function index(){

        $Session = auth()->user();
        //CATALOGOS
        $Departamentos = Departamentos::where('id', '>', 2)->get(['id', 'Nombre']);

        $Insumos = Insumos::with('Departamento')->get();

        return Inertia::render('Compras/Insumos/Insumos', compact('Session', 'Departamentos', 'Insumos'));
    }

    public function store(Request $request){

        Validator::make($request->all(),[
            'IdUser' => ['required'],
            'Clave' => ['required'],
            'Nombre' => ['required'],
            'Linea' => ['required'],
            'Unidad' => ['required'],
            'Cantidad' => ['required'],
            'Departamento_id' => ['required'],
        ])->validate();

        Insumos::create($request->all());

        return redirect()->back();
    }

    public function update(Request $request, $id){

        Validator::make($request->all(),[
            'IdUser' => ['required'],
            'Clave' => ['required'],
            'Nombre' => ['required'],
            'Linea' => ['required'],
            'Unidad' => ['required'],
            'Cantidad' => ['required'],
            'Departamento_id' => ['required'],
        ])->validate();

        if ($request->has('id')) {
            Insumos::find($request->id)->update($request->all());
        }
        return redirect()->back();
    }
}
