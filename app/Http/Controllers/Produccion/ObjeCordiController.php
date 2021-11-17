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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        return $request;
        Validator::make($request->all(), [
            'proceso_id' => ['required'],
            'maq_pro_id' => ['required'],
            'paro_id' => ['required'],
            'departamento_id' => ['required'],
        ])->validate();


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
     * @param  \App\Models\obje_cordi  $obje_cordi
     * @return \Illuminate\Http\Response
     */
    public function show(obje_cordi $obje_cordi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\obje_cordi  $obje_cordi
     * @return \Illuminate\Http\Response
     */
    public function edit(obje_cordi $obje_cordi)
    {
        //
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
