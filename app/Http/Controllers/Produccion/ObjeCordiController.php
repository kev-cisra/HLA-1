<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\obje_cordi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ObjeCordiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //return $request;
        Validator::make($request->all(), [
            'proceso_id' => ['required'],
            'maq_pro_id' => ['required'],
            'norma' => ['required'],
            'departamento_id' => ['required'],
            'pro_hora' => ['required']
        ])->validate();

        obje_cordi::create([
            'proceso_id' => $request->proceso_id,
            'maq_pro_id' => $request->maq_pro_id,
            'clave_id' => $request->clave_id,
            'norma' => $request->norma,
            'departamento_id' => $request->departamento_id,
            'pro_hora' => $request->pro_hora
        ]);

        return redirect()->back()
            ->with('message', 'Post Created Successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\obje_cordi  $obje_cordi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, obje_cordi $obje_cordi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\obje_cordi  $obje_cordi
     * @return \Illuminate\Http\Response
     */
    public function destroy(obje_cordi $obje_cordi)
    {
        //
    }
}
