<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Produccion\carNorm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarNormController extends Controller
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
            'partida' => ['required'],
            'norma' => ['required'],
            'clave_id' => ['required'],
        ])->validate();
        $bus = carNorm::where('clave_id', '=', $request->clave_id)
        ->where('partida', '=', $request->partida)
        ->where('norma', '=', $request->norma)
        ->where('departamento_id', '=', $request->departamento_id)
        ->first();

        if (empty($bus->id)) {
            carNorm::create([
                'partida' => $request->partida,
                'norma' => $request->norma,
                'clave_id' => $request->clave_id,
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
     * @param  \App\Models\Produccion\carNorm  $carNorm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, carNorm $carNorm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produccion\carNorm  $carNorm
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        if ($request->has('id')) {
            carNorm::find($request->input('id'))->delete();
            return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
        }
    }
}
