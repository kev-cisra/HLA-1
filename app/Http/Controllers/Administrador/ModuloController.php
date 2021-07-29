<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Administrador\Catalogos\AreasModulos;
use App\Models\Administrador\Modulos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

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
        $areaModulos = AreasModulos::all();
        return Inertia::render('Administrador/modulos', ['usuario' => $usuario, 'modulos' => $modulos, 'areaM' => $areaModulos]);
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
            'NombreModulo' => ['required'],
            'Icono' => ['required'],
            'Ruta' => ['required'],
            'Area' => ['required'],
        ])->validate();

        Modulos::create($request->all());
        return redirect()->back()
                 ->with('message', 'Post Created Successfully.');
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
        Validator::make($request->all(), [
            'NombreModulo' => ['required'],
            'Icono' => ['required'],
            'Ruta' => ['required'],
            'Area' => ['required'],
        ])->validate();

        if ($request->has('id')) {
            Modulos::find($request->input('id'))->update($request->all());
            return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Administrador\Modulos  $modulos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        if ($request->has('id')) {
            Modulos::find($request->input('id'))->delete();
            return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
        }
    }
}
