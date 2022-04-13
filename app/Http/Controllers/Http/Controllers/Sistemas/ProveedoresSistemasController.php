<?php

namespace App\Http\Controllers\Sistemas;

use App\Http\Controllers\Controller;
use App\Models\Sistemas\Requisiciones\ProveedoresSistemas;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProveedoresSistemasController extends Controller{

    public function index(){
        $Session = auth()->user();
        $Proveedores = ProveedoresSistemas::get(['id', 'Nombre']);

        return Inertia::render('Sistemas/Proveedores/Proveedores', compact('Session', 'Proveedores'));
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
        // return $request;
        Validator::make($request->all(), [
            'IdUser' => ['required'],
            'Nombre' => ['required'],
        ])->validate();

        if ($request->has('id')) {
            ProveedoresSistemas::where('id','=',$request->id)->update([
                'Nombre' => $request->Nombre,
            ]);
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
