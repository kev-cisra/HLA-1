<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Produccion\catalogos\materiales;
use App\Models\Produccion\catalogos\procesos;
use App\Models\RecursosHumanos\Catalogos\Areas;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class MaterialesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        //Muestra el id de la persona que inicio sesion
        $usuario = Auth::user();
        //muestra la información del usuario que inicio sesion
        $perf = PerfilesUsuarios::where('IdEmp','=',$usuario->IdEmp)
            ->first();

        $mate = materiales::get();


        return Inertia::render('Produccion/Materiales', ['usuario' => $perf,'materiales' => $mate]);
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
        Validator::make($request->all(), [
            'idmat' => ['required','unique:materiales'],
            'nommat' => ['required'],
            'descrip' => ['required'],
        ])->validate();

        materiales::create($request->all());

        return redirect()->back()
            ->with('message', 'Post Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produccion\catalogos\materiales  $materiales
     * @return \Illuminate\Http\Response
     */
    public function show(materiales $materiales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produccion\catalogos\materiales  $materiales
     * @return \Illuminate\Http\Response
     */
    public function edit(materiales $materiales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produccion\catalogos\materiales  $materiales
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, materiales $materiales)
    {
        //
        Validator::make($request->all(), [
            'idmat' => ['required'],
            'nommat' => ['required'],
            'descrip' => ['required'],
        ])->validate();

        if ($request->has('id')) {
            materiales::find($request->input('id'))->update($request->all());
            return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produccion\catalogos\materiales  $materiales
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        if ($request->has('id')) {
            materiales::find($request->input('id'))->delete();
            return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
        }
    }
}
