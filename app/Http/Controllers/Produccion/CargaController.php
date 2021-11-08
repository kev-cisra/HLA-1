<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Produccion\carga;
use App\Models\Produccion\carNorm;
use App\Models\Produccion\carOpe;
use App\Models\Produccion\catalogos\procesos;
use App\Models\Produccion\dep_mat;
use App\Models\Produccion\dep_per;
use App\Models\Produccion\notasCarga;
use App\Models\Produccion\turnos;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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

        $depa = [];
        $carga = [];
        $procesos = [];
        $personal = [];
        $mate = [];
        $carOpe = [];
        $carNor = [];
        $turnos = [];
        $hoy = date('Y-m-d');
        $dia = date("Y-m-d",strtotime($hoy."- 1 days")).' 19:00:00';
        $mañana = date("Y-m-d",strtotime($hoy."+ 1 days")).' 07:00:00';
        //return $mañana;

        if (count($perf->dep_pers) != 0) {
            //muestran los departamentos
            $depa = $perf->dep_pers;
            //muestra de procesos dependiendo del puesto
            /* $procesos = procesos::where('departamento_id', '=', $perf->Departamento_id)
                ->where('tipo','!=', '3')
                ->where('tipo', '!=', '4')
                ->with([
                    'maq_pros' => function($mp){
                        $mp->select('id', 'proceso_id', 'maquina_id');
                    },
                    'maq_pros.maquinas' => function($ma){
                        $ma->select('id', 'Nombre', 'departamento_id');
                    },
                    'maq_pros.maquinas.marca'=> function($maq){
                        $maq->select('id', 'Nombre', 'maquinas_id');
                    },
                ])
                ->get(); */
            //muestra el personal del departamento
            /* $personal = dep_per::where('departamento_id', '=', $perf->Departamento_id)
                ->with([
                    'perfiles' => function($perfi){
                        $perfi->select('id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat');
                    },
                    'equipo' => function($eq){
                        $eq -> select('id', 'nombre', 'turno_id');
                    },
                    'equipo.turnos' => function($tur){
                        $tur -> select('id', 'nomtur');
                    }
                ])
                ->get(['id', 'perfiles_usuarios_id', 'ope_puesto', 'departamento_id', 'equipo_id']); */
            //materiales
            /* $mate = dep_mat::where('departamento_id', '=', $perf->Departamento_id)
                ->with([
                    'materiales' => function($mat){
                        $mat->select('id','idmat', 'nommat');
                    },
                    'claves' => function($cla){
                        $cla -> select('id', 'CVE_ART', 'DESCR', 'UNI_MED', 'dep_mat_id');
                    }
                ])
                ->get(); */
            //carga
            /* $bus = $perf->Departamento_id;
            $carga = carga::whereBetween('fecha', [$dia, $mañana])
            ->orWhere(function($q) use ($dia){
                $q->whereDate('fecha', '<=', $dia)
                ->where('notaPen', '=', '2');
            })
            ->with([
                'dep_perf' => function($dp) use($bus) {
                    $dp -> where('departamento_id', '=', $bus)
                        ->withTrashed()
                        ->select('id', 'perfiles_usuarios_id', 'ope_puesto', 'departamento_id');
                },
                'dep_perf.perfiles' => function($perfi){
                    $perfi->withTrashed()
                    ->select('id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat');
                },
                'dep_perf.departamentos' => function($dp_de){
                    $dp_de ->withTrashed()
                    -> select('id', 'Nombre', 'departamento_id');
                },
                'equipo' => function($eq){
                    $eq ->withTrashed()
                    -> select('id', 'nombre');
                },
                'turno' => function($tu){
                    $tu ->withTrashed()
                    ->select('id', 'nomtur');
                },
                'maq_pro' => function($mp){
                    $mp ->withTrashed()
                    ->select('id', 'proceso_id', 'maquina_id');
                },
                'maq_pro.maquinas' => function($ma){
                    $ma ->withTrashed()
                    -> select('id', 'Nombre');
                },
                'proceso' => function($pr){
                    $pr ->withTrashed()
                    -> select('id', 'nompro', 'tipo', 'proceso_id');
                },
                'dep_mat' => function($dp){
                    $dp ->withTrashed()
                    -> select('id', 'material_id');
                },
                'dep_mat.materiales' => function($mat){
                    $mat ->withTrashed()
                    -> select('id', 'idmat', 'nommat');
                },
                'clave' => function($cla){
                    $cla ->withTrashed()
                    -> select('id', 'CVE_ART', 'DESCR');
                },
                'notas' => function($not){
                    $not ->withTrashed()
                    -> latest()
                    -> select('id', 'fecha', 'nota', 'carga_id');
                }
            ])
            ->get(['id','fecha','semana','valor','partida','notaPen','equipo_id','dep_perf_id','per_carga','maq_pro_id','proceso_id','norma','clave_id','turno_id']); */
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
                ->where('tipo', '!=', '4')
                ->with([
                    'maq_pros' => function($mp){
                        $mp->select('id', 'proceso_id', 'maquina_id');
                    },
                    'maq_pros.maquinas' => function($ma){
                        $ma->select('id', 'Nombre', 'departamento_id');
                    },
                    'maq_pros.maquinas.marca'=> function($maq){
                        $maq->select('id', 'Nombre', 'maquinas_id');
                    },
                ])
                ->get();

            //muestra el personal del departamento
            $personal = dep_per::where('departamento_id', '=', $request->busca)
                ->with([
                    'perfiles' => function($perfi){
                        $perfi->select('id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat');
                    },
                    'equipo' => function($eq){
                        $eq -> select('id', 'nombre', 'turno_id');
                    },
                    'equipo.turnos' => function($tur){
                        $tur -> select('id', 'nomtur');
                    }
                ])
                ->get(['id', 'perfiles_usuarios_id', 'ope_puesto', 'departamento_id', 'equipo_id']);

            //muestra materiales
            $mate = dep_mat::where('departamento_id', '=', $request->busca)
                    ->with([
                        'materiales' => function($mat){
                            $mat->select('id','idmat', 'nommat');
                        },
                        'claves' => function($cla){
                            $cla -> select('id', 'CVE_ART', 'DESCR', 'UNI_MED', 'dep_mat_id');
                        }
                    ])
                    ->get();

            //carga
            $bus = $request->busca;
            $carga = carga::where('departamento_id', '=', $bus)
            ->whereBetween('fecha', [$dia, $mañana])
            ->orWhere(function($q) use ($dia){
                $q->whereDate('fecha', '<=', $dia)
                ->where('notaPen', '=', '2');
            })
            ->with([
                'dep_perf' => function($dp) use($bus) {
                    $dp -> withTrashed()
                        ->select('id', 'perfiles_usuarios_id', 'ope_puesto', 'departamento_id');
                },
                'dep_perf.perfiles' => function($perfi){
                    $perfi->withTrashed()
                    ->select('id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat');
                },
                'dep_perf.departamentos' => function($dp_de){
                    $dp_de -> select('id', 'Nombre', 'departamento_id');
                },
                'equipo' => function($eq){
                    $eq -> select('id', 'nombre');
                },
                'turno' => function($tu){
                    $tu ->select('id', 'nomtur');
                },
                'maq_pro' => function($mp){
                    $mp ->withTrashed()
                    ->select('id', 'proceso_id', 'maquina_id');
                },
                'maq_pro.maquinas' => function($ma){
                    $ma ->withTrashed()
                    -> select('id', 'Nombre');
                },
                'proceso' => function($pr){
                    $pr -> select('id', 'nompro', 'tipo', 'proceso_id');
                },
                'dep_mat' => function($dp){
                    $dp ->withTrashed()
                    -> select('id', 'material_id');
                },
                'dep_mat.materiales' => function($mat){
                    $mat ->withTrashed()
                    -> select('id', 'idmat', 'nommat');
                },
                'clave' => function($cla){
                    $cla ->withTrashed()
                    -> select('id', 'CVE_ART', 'DESCR');
                },
                'notas' => function($not){
                    $not -> latest()
                    -> select('id', 'fecha', 'nota', 'carga_id');
                }
            ])
            ->get(['id','fecha','semana','valor','partida','notaPen','equipo_id','dep_perf_id','per_carga','maq_pro_id','proceso_id','norma','clave_id','turno_id']);

            //Paquetes de operador
            $carOpe = carOpe::where('departamento_id', '=', $request->busca)
            ->with([
                'proceso' => function($pro) {
                    $pro -> select('id', 'nompro', 'proceso_id');
                },
                'proceso.proceso_sub' => function($pp) {
                    $pp -> select('id', 'nompro', 'proceso_id');
                },
                'dep_per' => function($dp) {
                    $dp -> select('id', 'perfiles_usuarios_id', 'equipo_id');
                },
                'dep_per.perfiles' => function($per) {
                    $per -> select('id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat');
                },
                'dep_per.equipo' => function($equ) {
                    $equ -> select('id', 'nombre', 'turno_id');
                },
                'dep_per.equipo.turnos' => function($tur) {
                    $tur -> select('id', 'nomtur');
                },
                'maq_pro' => function($mp) {
                    $mp -> select('id', 'maquina_id');
                },
                'maq_pro.maquinas' => function($maq) {
                    $maq -> select('id', 'Nombre');
                },
                'maq_pro.maquinas.marca'=> function($maq){
                    $maq->select('id', 'Nombre', 'maquinas_id');
                },
            ])
            ->get(['id', 'estatus', 'proceso_id', 'dep_perf_id', 'maq_pro_id', 'departamento_id']);

            //Paquete Normas Claves y partida
            $carNor = carNorm::where('departamento_id', '=', $request->busca)
            ->with([
                'dep_mat' => function($dm){
                    $dm -> select('id', 'departamento_id', 'material_id');
                },
                'dep_mat.materiales' => function($mat){
                    $mat->select('id','idmat', 'nommat');
                },
                'clave' => function($cla){
                    $cla -> select('id', 'CVE_ART', 'DESCR', 'UNI_MED', 'dep_mat_id');
                }
            ])
            ->get(['id', 'partida', 'estatus', 'norma', 'clave_id', 'departamento_id']);

            //Turnos
            $turnos = turnos::where('departamento_id', '=', $request->busca)
            ->with([
                'equipos' => function ($eq) {
                    $eq -> select('id', 'nombre', 'turno_id');
                }
            ])
            ->get(['id', 'nomtur', 'departamento_id']);
        }
        return Inertia::render('Produccion/Carga', ['usuario' => $perf, 'depa' => $depa, 'cargas' => $carga, 'procesos' => $procesos, 'personal' => $personal, 'materiales' => $mate, 'paqope' => $carOpe, 'paqnor' => $carNor, 'turnos' => $turnos]);

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
        //return $request;
        Validator::make($request->all(), [
            'proceso_id' => ['required'],
            'dep_perf_id' => ['required'],
            'valor' => ['required'],
            'clave_id' => ['numeric'],
        ])->validate();

        $nFecha = $request->fecha.' '.date('H:i:s');
        if ($request->vacio == 'N/A' | $request->vacio != 'Vacío') {
            carga::create([
                'fecha' => $nFecha,
                'semana' => $request->semana,
                'per_carga' => $request->per_carga,
                'proceso_id' => $request->proceso_id,
                'dep_perf_id' => $request->dep_perf_id,
                'maq_pro_id' => $request->maq_pro_id,
                'partida' => $request->partida,
                'valor' => $request->valor,
                'norma' => $request->norma,
                'equipo_id' => $request->equipo_id,
                'clave_id' => $request->clave_id,
                'turno_id' => $request->turno_id,
                'notaPen' => $request->notaPen,
                'departamento_id' => $request->departamento_id,
                'VerInv' => $request->VerInv
            ]);
        }


        return redirect()->back()
            ->with('message', 'Post Created Successfully.');
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
        //return $request;
        Validator::make($request->all(), [
            'clave_id' => ['required'],
            'valor' => ['required'],
            'nota' => ['required']
        ])->validate();
        //carga de procesos
        carga::find($request->input('id'))
        ->update([
            'norma' => $request->norma,
            'clave_id' => $request->clave_id,
            'partida' => $request->partida,
            'valor' => $request->valor,
            'notaPen' => 1
        ]);
        //carga de notas
        notasCarga::create([
            'fecha' => $request->fecha,
            'nota' => $request->nota,
            'perfil_id' => $request->usu,
            'carga_id' => $request->id
        ]);
        return redirect()->back()
            ->with('message', 'Post Created Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produccion\carga  $carga
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        if ($request->has('id')) {
            carga::find($request->input('id'))->delete();
            return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
        }
    }
}
