<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Produccion\procesos;
use App\Models\RecursosHumanos\Catalogos\Areas;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProcesosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $usuario = Auth::id();
        //$procesos = procesos::all();

        /*$categories = PerfilesUsuarios::with('jefe_perfiles')
        ->where('IdUser','=',$usuario)
        ->get();
        */

        $perf = PerfilesUsuarios::where('IdUser','=',$usuario)
        ->get();
        $areaid = $perf->Areas_id;

        /*$subare = Areas::with('sub_areas')
        ->where('sub_areas','=',$perf->Areas_id)
        ->get();

        $idemp = $usuario -> IdEmp;
        $usua = PerfilesUsuarios::where('ID', '=', 1);

        foreach ($usua as  $value) {
            $idusuario = $value->id;
        }

        $usu = User::find(1);

        $idusuario = $usu->id;
        $nombre = $usu->Nombre;*/



        return Inertia::render('Produccion/Procesos', ['usuario' => $usuario,'procesos' => $areaid]);

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
     * @param  \App\Models\Produccion\procesos  $procesos
     * @return \Illuminate\Http\Response
     */
    public function show(procesos $procesos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produccion\procesos  $procesos
     * @return \Illuminate\Http\Response
     */
    public function edit(procesos $procesos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produccion\procesos  $procesos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, procesos $procesos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produccion\procesos  $procesos
     * @return \Illuminate\Http\Response
     */
    public function destroy(procesos $procesos)
    {
        //
    }
}
