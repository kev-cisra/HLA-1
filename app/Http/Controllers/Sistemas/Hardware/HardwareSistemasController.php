<?php

namespace App\Http\Controllers\Sistemas\Hardware;

use App\Http\Controllers\Controller;
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
        HardwareSistemas::create($request->all());
        return redirect()->back();
    }

    public function update(Request $request, $id){

        if ($request->has('id')) {
            HardwareSistemas::find($request->id)->update($request->all());
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
