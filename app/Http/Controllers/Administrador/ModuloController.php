<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Administrador\Modulos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ModuloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $usuario = Auth::user();
        $modulos = Modulos::all();
        return Inertia::render('Administrador/modulos', ['usuario' => $usuario, 'modulos' => $modulos]);
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
     * @param  \App\Models\Administrador\Modulos  $modulos
     * @return \Illuminate\Http\Response
     */
    public function show(Modulos $modulos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Administrador\Modulos  $modulos
     * @return \Illuminate\Http\Response
     */
    public function edit(Modulos $modulos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Administrador\Modulos  $modulos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Modulos $modulos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Administrador\Modulos  $modulos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Modulos $modulos)
    {
        //
    }
}
