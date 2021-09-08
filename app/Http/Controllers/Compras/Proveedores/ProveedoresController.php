<?php

namespace App\Http\Controllers\Compras\Proveedores;

use App\Http\Controllers\Controller;
use App\Models\Compras\Proveedores;
use Illuminate\Http\Request;
use Inertia\Inertia;
class ProveedoresController extends Controller{

    public function index(){

        $Session = auth()->user();

        $Proveedores = Proveedores::get();

        return Inertia::render('Compras/Proveedores/Proveedores', compact('Session', 'Proveedores'));
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
