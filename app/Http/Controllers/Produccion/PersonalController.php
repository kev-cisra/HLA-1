<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Produccion\are_prof;
use App\Models\RecursosHumanos\Catalogos\Areas;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $usuario = Auth::id();

        $perf = PerfilesUsuarios::where('IdUser','=',$usuario)
        ->get();

        $idarepro = Areas::where('idArea', '=', 'PRO')
            ->first();

        $areas = Areas::where('areas_id', '=', $idarepro->id)
            ->with('sub_areas')
            ->get(['id', 'IdUser', 'idArea', 'Nombre', 'areas_id']);

        $personal = PerfilesUsuarios::get();
        $areper = empty($request->busca) ? NULL : are_prof::where('area_id', '=', $request->busca)
        ->with([
            'areperf_area' => function($area){
                $area->select('id', 'idArea', 'Nombre', 'tipo', 'areas_id');
            },
            'areperf_perfil' => function($perfi){
                $perfi->select('id', 'IdEmp','Empresa', 'Nombre', 'ApPat', 'ApMat');
            }])
        ->get();



        return Inertia::render('Produccion/Personal', ['usuario' => $perf, 'areas' => $areas, 'personal' => $personal, 'areper' => $areper]);
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
                'area_id' => 'required',
                'perfiles_usuarios_id' => ['required','numeric'],
        ])->validate();

        $cuenta = are_prof::where('perfiles_usuarios_id', '=', $request->perfiles_usuarios_id)
        ->where('area_id', '=', $request->area_id)
        ->count();

        if($cuenta == 1) {

            Validator::make($request->all(), [
                'perfiles_usuarios_id' => 'unique:are_profs'
            ])->validate();
        }

        are_prof::create($request->all());

        return redirect()->back()
            ->with('message', 'Post Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produccion\are_prof  $are_prof
     * @return \Illuminate\Http\Response
     */
    public function show(are_prof $are_prof)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produccion\are_prof  $are_prof
     * @return \Illuminate\Http\Response
     */
    public function edit(are_prof $are_prof)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produccion\are_prof  $are_prof
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, are_prof $are_prof)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produccion\are_prof  $are_prof
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        if ($request->has('id')) {
            are_prof::find($request->input('id'))->delete();
            return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
        }
    }
}
