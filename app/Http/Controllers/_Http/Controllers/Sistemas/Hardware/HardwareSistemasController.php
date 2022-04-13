<?php

namespace App\Http\Controllers\Sistemas\Hardware;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Sistemas\Hardware\HardwareSistemas;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HardwareSistemasController extends Controller{

    public function index(){
        $Session = auth()->user();
        $EquiposComputo = HardwareSistemas::get();
        return Inertia::render('Sistemas/Equipos/EquiposComputo', compact('Session','EquiposComputo'));
    }

    public function store(Request $request){

        Validator::make($request->all(), [
            'IdUser' => ['required'],
            'Nombre' => ['required'],
            'Marca' => ['required'],
            'Modelo' => ['required'],
            'NumeroSerie' => ['required'],
        ])->validate();

        HardwareSistemas::create($request->all());
        return redirect()->back();
    }

    public function update(Request $request, $id){

        Validator::make($request->all(), [
            'IdUser' => ['required'],
            'Nombre' => ['required'],
            'Marca' => ['required'],
            'Modelo' => ['required'],
            'NumeroSerie' => ['required'],
        ])->validate();

        if ($request->has('id')) {
            HardwareSistemas::find($request->id)->update($request->all());
        }
        return redirect()->back();
    }

    public function destroy($id)
    {
        //
    }
}
