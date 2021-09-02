<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Produccion\carga;
use App\Models\Produccion\catalogos\procesos;
use App\Models\Produccion\dep_per;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CargaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        ///***************** Información de la persona  *****************************/
        //Muestra el id de la persona que inicio sesion
        $usuario = Auth::id();
        //muestra la información del usuario que inicio sesion
        $perf = PerfilesUsuarios::where('user_id','=',$usuario)
            ->with([
                'dep_pers' => function($dp){
                    $dp -> select('id', 'perfiles_usuarios_id', 'ope_puesto', 'equipo_id', 'departamento_id');
                },
                'dep_pers.equipo' => function($dp_eq){
                    $dp_eq -> select('id', 'nombre', 'turno_id', 'departamento_id');
                },
                'dep_pers.departamentos' => function($dp_de){
                    $dp_de -> select('id', 'Nombre', 'departamento_id');
                }
            ])
            ->first(['id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat', 'jefe_id', 'user_id', 'Puesto_id', 'Departamento_id', 'jefes_areas_id']);

        $depa = NULL;
        $carga = null;
        $procesos = null;
        $personal = null;

        if (count($perf->dep_pers) != 0) {
            //muestran los departamentos
            $depa = $perf->dep_pers;
            //muestra de procesos dependiendo del puesto
            $procesos = procesos::where('departamento_id', '=', $perf->Departamento_id)
                ->where('tipo','!=', '3')
                ->get();
            //muestra el personal del departamento
            $personal = dep_per::where('departamento_id', '=', $perf->Departamento_id)
                ->with([
                    'perfiles' => function($perfi){
                        $perfi->select('id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat');
                    }
                ])
                ->get();
            $d = 0;
            /*foreach ($perf->dep_pers as $value) {
                if ($value->ope_puesto != 'ope'|| $value->ope_puesto != 'lid') {
                    $procesos = procesos::where('tipo','!=', '2')
                        ->where('tipo','!=', '3')
                        ->get();
                }elseif ($value->ope_puesto != 'cor') {
                    $procesos = procesos::where('tipo','!=', '1')
                        ->where('tipo','!=', '3')
                        ->get();
                }
            }*/
        }else{
            //consulta el id de la area produccion
            $iddeppro = Departamentos::where('Nombre', '=', 'OPERACIONES')
                ->first();
            //muestra las areas y sub areas de produccion
            $depa = Departamentos::where('departamento_id', '=', $iddeppro->id)
                ->with('sub_Departamentos')
                ->get(['id', 'IdUser', 'Nombre', 'departamento_id']);
        }



        /**************************** consulta si existe la busqueda  ****************************************************/
        if (!empty($request->busca)) {
            //muestran los departamentos
            $procesos = procesos::where('departamento_id', '=', $request->busca)
                ->where('tipo', '!=', '3')
                ->get();
            //muestra el personal del departamento
            $personal = dep_per::where('departamento_id', '=', $request->busca)
                ->with([
                    'perfiles' => function($perfi){
                        $perfi->select('id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat');
                    }
                ])
                ->get();
        }


        return Inertia::render('Produccion/Carga', ['usuario' => $perf, 'depa' => $depa, 'cargas' => $carga, 'procesos' => $procesos, 'personal' => $personal]);

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
     * @param  \App\Models\Produccion\carga  $carga
     * @return \Illuminate\Http\Response
     */
    public function show(carga $carga)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produccion\carga  $carga
     * @return \Illuminate\Http\Response
     */
    public function edit(carga $carga)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produccion\carga  $carga
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, carga $carga)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produccion\carga  $carga
     * @return \Illuminate\Http\Response
     */
    public function destroy(carga $carga)
    {
        //
    }
}
