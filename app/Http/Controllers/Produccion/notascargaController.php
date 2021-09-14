<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Produccion\carga;
use App\Models\Produccion\notasCarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class notascargaController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produccion\notasCarga  $notasCarga
     * @return \Illuminate\Http\Response
     */
    public function show(notasCarga $notasCarga)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produccion\notasCarga  $notasCarga
     * @return \Illuminate\Http\Response
     */
    public function edit(notasCarga $notasCarga)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produccion\notasCarga  $notasCarga
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, notasCarga $notasCarga)
    {
        //
        Validator::make($request->all(), [
            'nota' => ['required']
        ])->validate();
        carga::find($request->input('id'))->update(['notaPen' => 2]);
        notasCarga::create([
            'fecha' => $request->fecha,
            'nota' => $request->nota,
            'perfil_id' => $request->usu,
            'carga_id' => $request->idnota
        ]);
        return redirect()->back()
            ->with('message', 'Post Created Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produccion\notasCarga  $notasCarga
     * @return \Illuminate\Http\Response
     */
    public function destroy(notasCarga $notasCarga)
    {
        //
    }
}
