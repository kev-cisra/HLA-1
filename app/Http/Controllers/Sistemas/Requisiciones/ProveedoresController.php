<?php

namespace App\Http\Controllers\Sistemas\Requisiciones;

use App\Http\Controllers\Controller;
use App\Models\Sistemas\Requisiciones\ProveedoresSistemas;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Inertia\Inertia;


class ProveedoresController extends Controller{

    public function index(Request $request){
        $Session = auth()->user();

        $Proveedores = ProveedoresSistemas::get();
        //retorno de la vista retorno de la consulta de perfiles y sus filtros
        return Inertia::render('Sistemas/Requisiciones/Proveedores', compact('Session', 'Proveedores'));
    }

    public function store(Request $request){

        Validator::make($request->all(), [
            'IdUser' => ['required'],
            'Nombre' => ['required'],
        ])->validate();

        ProveedoresSistemas::create($request->all());
        return redirect()->back();
    }

    public function update(Request $request, $id){

        Validator::make($request->all(), [
            'IdUser' => ['required'],
            'Nombre' => ['required'],
        ])->validate();

        if ($request->has('id')) {
            ProveedoresSistemas::find($request->id)->update($request->all());
        }
        return redirect()->back();
    }

    public function destroy(Request $request){
        if ($request->has('id')) {
            ProveedoresSistemas::find($request->input('id'))->delete();
            return redirect()->back();
        }
    }
}
