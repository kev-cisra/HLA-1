<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Produccion\carga;
use App\Models\Produccion\catalogos\procesos;
use App\Models\Produccion\dep_mat;
use App\Models\Produccion\dep_per;
use App\Models\Produccion\paros;
use App\Models\Produccion\parosCarga;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ParosController extends Controller
{
    //
    public function index(Request $request){
        //Muestra el id de la persona que inicio sesion
        $usuario = Auth::user();
        //muestra la información del usuario que inicio sesion
        $perf = PerfilesUsuarios::where('IdEmp','=',$usuario->IdEmp)
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
        //manda array vacios
        $depa = [];
        $procesos = [];
        $carga = [];
        $mate = [];
        $hoy = date('Y-m-d');
        $dia = date("Y-m-d",strtotime($hoy."- 1 days")).' 19:00:00';
        $mañana = date("Y-m-d",strtotime($hoy."+ 1 days")).' 07:00:00';

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
                ->get();
            //materiales
            $mate = dep_mat::where('departamento_id', '=', $perf->Departamento_id)
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
            $bus = $perf->Departamento_id;
            $carga = carga::whereBetween('fecha', [$dia, $mañana])
                ->orWhere(function($q) use ($dia){
                    $q->whereDate('fecha', '<=', $dia)
                    ->where('notaPen', '=', '2');
                })
                ->with([
                    'dep_perf' => function($dp) use($bus) {
                        $dp -> where('departamento_id', '=', $bus)
                            ->select('id', 'perfiles_usuarios_id', 'ope_puesto', 'departamento_id');
                    },
                    'dep_perf.perfiles' => function($perfi){
                        $perfi->select('id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat');
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
                        $mp ->select('id', 'proceso_id', 'maquina_id');
                    },
                    'maq_pro.maquinas' => function($ma){
                        $ma -> select('id', 'Nombre');
                    },
                    'proceso' => function($pr){
                        $pr -> select('id', 'nompro', 'tipo_carga', 'proceso_id');
                    },
                    'dep_mat' => function($dp){
                        $dp -> select('id', 'material_id');
                    },
                    'dep_mat.materiales' => function($mat){
                        $mat -> select('id', 'idmat', 'nommat');
                    },
                    'clave' => function($cla){
                        $cla -> select('id', 'CVE_ART', 'DESCR');
                    },
                    'notas' => function($not){
                        $not -> latest()
                        -> select('id', 'fecha', 'nota', 'carga_id');
                    }
                ])
                ->get(['id','fecha','semana','valor','partida','notaPen','equipo_id','dep_perf_id','per_carga','maq_pro_id','proceso_id','norma','clave_id','turno_id']);
                     */

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
            $carga = parosCarga::where('departamento_id', '=', $request->busca)
                ->with([
                    'paros' => function($pr){
                        $pr->select('id', 'clave', 'descri', 'tipo');
                    },
                    'perfil_ini' => function($pini){
                        $pini->select('id', 'Nombre', 'ApPat', 'ApMat');
                    },
                    'maq_pro' => function($mp){
                        $mp->select('id', 'maquina_id', 'proceso_id');
                    },
                    'maq_pro.maquinas' => function($ma) {
                        $ma->select('id', 'Nombre');
                    },
                    'proceso' => function($po) {
                        $po->select('id', 'nompro');
                    },
                    'departamento' => function($dep) {
                        $dep->select('id', 'Nombre');
                    }
                ])
                ->get(['id', 'fecha', 'iniFecha', 'orden', 'descri', 'finFecha', 'tiempo','paro_id', 'perfil_ini_id','perfil_fin_id', 'maq_pro_id', 'proceso_id', 'departamento_id']);

        }

        //paros
        $paros = paros::get();

        return Inertia::render('Produccion/Paros', ['usuario' => $perf, 'depa' => $depa, 'procesos' => $procesos, 'cargas' => $carga, 'materiales' => $mate, 'paros' => $paros]);
    }

    public function store(Request $request)
    {
        //
        //return $request;
        Validator::make($request->all(), [
            'proceso_id' => ['required'],
            'maq_pro_id' => ['required'],
            'paro_id' => ['required'],
            'departamento_id' => ['required'],
            ])->validate();

        parosCarga::create([
            'fecha' => $request->fecha,
            'iniFecha' => $request->fecha,
            'paro_id' => $request->paro_id,
            'perfil_ini_id' => $request->usu,
            'maq_pro_id' => $request->maq_pro_id,
            'proceso_id' => $request->proceso_id,
            'orden' => $request->orden,
            'descri' => $request->descri,
            'departamento_id' => $request->departamento_id
        ]);

        return redirect()->back()
            ->with('message', 'Post Created Successfully.');
    }
}
