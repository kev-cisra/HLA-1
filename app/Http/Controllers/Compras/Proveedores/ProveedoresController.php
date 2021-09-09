<?php

namespace App\Http\Controllers\Compras\Proveedores;

use App\Http\Controllers\Controller;
use App\Models\Compras\Proveedores;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Inertia\Inertia;
class ProveedoresController extends Controller{

    public function index(){

        $Session = auth()->user();

        $Proveedores = Proveedores::with('ProveedorDepartamento')->get();

        $Departamentos = Departamentos::orderBy('Nombre', 'asc')->get(['id','Nombre']);

        return Inertia::render('Compras/Proveedores/Proveedores', compact('Session', 'Proveedores', 'Departamentos'));
    }


    public function store(Request $request){

        Validator::make($request->all(), [
            'Nombre' => ['required'],
            'Departamentos_id' => ['required'],
            'TipoPago' => ['required'],
        ])->validate();

        Proveedores::create([
            'IdUser' => $request->IdUser,
            'Nombre' => $request->Nombre,
            'Departamentos_id' => $request->Departamentos_id,
            'TipoPago' =>  $request->TipoPago,
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id){

        Validator::make($request->all(), [
            'Nombre' => ['required'],
            'Departamentos_id' => ['required'],
            'TipoPago' => ['required'],
        ])->validate();

        if ($request->has('id')) {
            Proveedores::find($request->input('id'))->update($request->all());
            return redirect()->back();
        }
    }


    public function destroy(Request $request){

        if ($request->has('id')) {
            Proveedores::find($request->input('id'))->delete();
            return redirect()->back();
        }
    }
}
