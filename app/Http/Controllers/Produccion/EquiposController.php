<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Produccion\dep_per;
use App\Models\Produccion\equipos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EquiposController extends Controller
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
        Validator::make($request->all(), [
            'turno_id' => ['required'],
            'nombre' => ['required'],
            'departamento_id' => ['required']
        ])->validate();

        $query = equipos::where('departamento_id', '=', $request->departamento_id)
                ->where('nombre', '=', $request->nombre)
                ->first();
        if(!empty($query)){
            /*Validator::make($request->all(), [
                'nombre' => ['unique:equipos']
            ])->validate();*/
            equipos::find($query->id)->update([
                'turno_id' => $request->turno_id
            ]);
            if(count($request->emp) > 0){
                foreach ($request->emp as $value) {
                    dep_per::find($value)->update([
                        'equipo_id' => $query->id
                    ]);
                }
            }
            //return $query;
        }else{
            $equi = equipos::create($request->all());

            if(count($request->emp) > 0){
                foreach ($request->emp as $value) {
                    dep_per::find($value)->update([
                        'equipo_id' => $equi->id
                    ]);
                }
            }
        }

        //return $request->emp;

        return redirect()->back()
            ->with('message', 'Post Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produccion\equipos  $equipos
     * @return \Illuminate\Http\Response
     */
    public function show(equipos $equipos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produccion\equipos  $equipos
     * @return \Illuminate\Http\Response
     */
    public function edit(equipos $equipos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produccion\equipos  $equipos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, equipos $equipos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produccion\equipos  $equipos
     * @return \Illuminate\Http\Response
     */
    public function destroy(equipos $equipos)
    {
        //
    }
}
