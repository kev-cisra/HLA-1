<?php

namespace App\Http\Controllers\Compras\Papeleria;

use App\Http\Controllers\Controller;
use App\Models\Compras\Papeleria\MaterialPapeleria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class AltaMaterialPapeleriaController extends Controller{

    public function index(){

        $Session = auth()->user();

        $MaterialPapeleria = MaterialPapeleria::get();

        return Inertia::render('Compras/Papeleria/AltaMaterialPapeleria', compact('Session', 'MaterialPapeleria'));
    }

    public function store(Request $request)
    {
        //
        Validator::make($request->all(), [
            'Nombre' => ['required'],
            'Unidad' => ['required'],
        ])->validate();

        MaterialPapeleria::create($request->all());
        return redirect()->back();
    }

    public function update(Request $request, MaterialPapeleria $MaterialPapeleria){

        Validator::make($request->all(), [
            'Nombre' => ['required'],
            'Unidad' => ['required'],
        ])->validate();

        if ($request->has('id')) {
            MaterialPapeleria::find($request->input('id'))->update($request->all());
            return redirect()->back();
        }
    }

    public function destroy(Request $request){

        if ($request->has('id')) {
            MaterialPapeleria::find($request->input('id'))->delete();
            return redirect()->back();
        }
    }
}
