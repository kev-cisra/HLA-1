<?php

namespace App\Http\Controllers\Compras\Requisiciones;

use App\Http\Controllers\Controller;
use App\Models\Compras\Requisiciones\Requisiciones;
use Illuminate\Http\Request;
use Inertia\Inertia;
class RequisicionesController extends Controller{

    public function index(){

        $Session = auth()->user();

        $Requisicion = Requisiciones::with('RequisicionesPerfil')->get();

        return Inertia::render('Compras/Requisiciones/index', compact('Session', 'Requisicion'));
    }

    public function create(){

    }

    public function store(Request $request){

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
