<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Produccion\formulas;
use App\Models\Produccion\procesos;
use App\Models\RecursosHumanos\Catalogos\Areas;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class ProcesosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        //echo $request->busca;
        $usuario = Auth::id();

        $perf = PerfilesUsuarios::where('IdUser','=',$usuario)
        ->with(['perfiles_area'=>function($query) {
                $query->select('id','Nombre', 'idArea');
            }
        ])
        ->first(['id', 'IdEmp', 'Empresa', 'Nombre', 'ApPat', 'ApMat', 'perfiles_usuarios_id', 'Areas_id']);

        $area = NULL;
        $proce = NULL;

        if($perf->perfiles_area->idArea == "PRO"){
            $area = Areas::with('sub_areas')
            ->get(['id', 'IdUser', 'idArea', 'Nombre', 'areas_id']);
            if(!empty($request->busca)){
                $proce = procesos::where('areas_id','=',$request->busca)
                ->with('procesos_area')
                ->get();
            }
        }else{
            $proce = procesos::where('areas_id','=',$perf->Areas_id)
            ->with('procesos_area')
            ->get();
        }



        return Inertia::render('Produccion/Procesos', ['usuario' => $perf,'procesos' => $proce,'areas' => $area]);

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

        //echo $request['form'];
        Validator::make($request->all(), [
            'nompro' => ['required'],
            'areas_id' => ['required'],
            'tipo' => ['required'],
            'descripcion' => ['required'],
        ])->validate();

        procesos::create($request->all());

        /*return response()->json(['proceso_id' => $ins->id])
            ->setCallback();*/

        return redirect()->back()
            ->with('message', 'Post Created Successfully.');

        //procesos::create($request['form']->all());
    }

    public function carform(Request $request){
        return 'si';
        /*return redirect()->back()
            ->with('message', 'Post Created Successfully.');*/
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
