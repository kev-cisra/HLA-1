<?php

namespace App\Http\Controllers\Sistemas\Equipos;

use App\Http\Controllers\Controller;
use App\Models\Sistemas\EquiposComputo;
use Illuminate\Http\Request;
use Inertia\Inertia;
class EquiposComputoController extends Controller{

    public function index(){
        $Session = auth()->user();
        $EquiposComputo = EquiposComputo::get();
        return Inertia::render('Sistemas/Equipos/EquiposComputo', compact('Session','EquiposComputo'));
    }


    public function store(Request $request){
        EquiposComputo::create($request->all());
        return redirect()->back();
    }

    public function update(Request $request, $id){

        if ($request->has('id')) {
            EquiposComputo::find($request->id)->update($request->all());
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
