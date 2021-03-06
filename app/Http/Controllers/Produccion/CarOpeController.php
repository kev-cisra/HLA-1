<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Produccion\carOpe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarOpeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        Validator::make($request->all(), [
            'proceso_id' => ['required'],
            'dep_perf_id' => ['required'],
            'maq_pro_id' => ['required'],
        ])->validate();

        $veri = carOpe::where('proceso_id', '=', $request->proceso_id)
        ->where('dep_perf_id', '=', $request->dep_perf_id)
        ->where('maq_pro_id', '=', $request->maq_pro_id)
        ->where('departamento_id', '=', $request->departamento_id)
        ->first();

        if (empty($veri->id)) {
            //carga de operador
            carOpe::create([
                'proceso_id' => $request->proceso_id,
                'dep_perf_id' => $request->dep_perf_id,
                'maq_pro_id' => $request->maq_pro_id,
                'departamento_id' => $request->departamento_id
            ]);
        }

        return redirect()->back()
            ->with('message', 'Post Created Successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produccion\carOpe  $carOpe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, carOpe $carOpe)
    {
        //
        Validator::make($request->all(), [
            'proceso_id' => ['required'],
            'dep_perf_id' => ['required'],
            'maq_pro_id' => ['required'],
        ])->validate();

        carOpe::find($request->input('id'))
        ->update([
            'proceso_id' => $request->proceso_id,
            'dep_perf_id' => $request->dep_perf_id,
            'maq_pro_id' => $request->maq_pro_id,
        ]);
        return redirect()->back()
            ->with('message', 'Post Created Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produccion\carOpe  $carOpe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        if (isset($request->ElMaOP)) {
            foreach ($request->ElMaOP as $val) {
                carOpe::find($val)->delete();
            }
        }else{
            if ($request->has('id')) {
                carOpe::find($request->input('id'))->delete();
            }
        }
        return redirect()->back()
            ->with('message', 'Post Updated Successfully.');
    }
}
