<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Produccion\carga;
use App\Models\Produccion\grafi_arr;
use App\Models\Produccion\pac_grafica;
use App\Models\Produccion\paros;
use App\Models\Produccion\parosCarga;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class RepoProController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Produccion.reporpro.index|admin.index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        //
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

        //Variables
        $depa = [];

        //Condicional
        if (count($perf->dep_pers) != 0) {
            //muestran los departamentos
            $depa = $perf->dep_pers;
        }else {
            //consulta el id de la area produccion
            $iddeppro = Departamentos::where('Nombre', '=', 'OPERACIONES')
                ->first();
            //muestra las areas y sub areas de produccion
            $depa = Departamentos::where('departamento_id', '=', $iddeppro->id)
                ->with('sub_Departamentos')
                ->get(['id', 'IdUser', 'Nombre', 'departamento_id']);
        }

        //claves de los paros
        $claParo = paros::get();

        return Inertia::render('Produccion/Reportes/RProduccion', ['usuario' => $perf, 'depa' => $depa, 'claParo' => $claParo]);
    }

    //Consulta para la produccion
    public function ConProdu(Request $request){
        //return $request;

        if ($request->tipo == 'dia') {
            $carga = carga::where('departamento_id', '=', $request->departamento_id)
            ->whereBetween('fecha', [$request->iniDia, $request->finDia])
            ->with([
                'dep_perf' => function($dp) {
                    $dp ->withTrashed()
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
                    -> select('id', 'nompro', 'tipo', 'operacion', 'proceso_id');
                },
                'dep_mat' => function($dp){
                    $dp ->withTrashed()
                    -> select('id', 'material_id');
                },
                'dep_mat.materiales' => function($mat){
                    $mat ->withTrashed()
                    -> select('id', 'idmat', 'nommat');
                },
                'objetivopunta'=> function($op){
                    $op->select('id', 'horas', 'valorPu', 'carga_id');
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
            ->get(['id','fecha','semana','valor','partida','notaPen','equipo_id','dep_perf_id','per_carga','maq_pro_id','proceso_id','norma','clave_id','turno_id','VerInv', 'departamento_id']);
        }
        elseif ($request->tipo == 'semana') {
            $carga = carga::where('departamento_id', '=', $request->departamento_id)
            ->where('semana', '=', $request->semana)
            ->whereNotNull('clave_id')
            ->where('partida', '!=', 'N/A')
            ->whereHas('proceso', function($q){
                $q->where('tipo', '!=', '3');
            })
            ->selectRaw('norma, proceso_id, departamento_id, SUM(valor) AS valor')
            ->groupBy('proceso_id')
            ->groupBy('norma')
            ->groupBy('departamento_id')
            ->with([
                'dep_perf' => function($dp) {
                    $dp ->withTrashed()
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
                    -> select('id', 'nompro', 'tipo', 'operacion', 'proceso_id');
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
            ->get();
        }
        elseif ($request->tipo == 'mes') {
            $carga = carga::where('departamento_id', '=', $request->departamento_id)
            ->where('fecha', 'LIKE', '%'.$request->mes.'%')
            ->with([
                'dep_perf' => function($dp) {
                    $dp ->withTrashed()
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
                    -> select('id', 'nompro', 'tipo', 'operacion', 'proceso_id');
                },
                'dep_mat' => function($dp){
                    $dp ->withTrashed()
                    -> select('id', 'material_id');
                },
                'dep_mat.materiales' => function($mat){
                    $mat ->withTrashed()
                    -> select('id', 'idmat', 'nommat');
                },
                'objetivopunta'=> function($op){
                    $op->select('id', 'horas', 'valorPu', 'carga_id');
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
            ->get(['id','fecha','semana','valor','partida','notaPen','equipo_id','dep_perf_id','per_carga','maq_pro_id','proceso_id','norma','clave_id','turno_id','VerInv', 'departamento_id']);
        }
        elseif ($request->tipo == 'ano') {}
        /*elseif ($request->tipo == 'rango') {
            $carga = carga::where('departamento_id', '=', $request->departamento_id)
            ->whereBetween('fecha', [$request->iniDia, $request->finDia])
            ->whereNotNull('clave_id')
            ->where('partida', '!=', 'N/A')
            ->selectRaw('clave_id, partida, norma, proceso_id, departamento_id, SUM(valor) AS valor, equipo_id, maq_pro_id')
            ->groupBy('departamento_id')
            ->groupBy('proceso_id')
            ->groupBy('maq_pro_id')
            ->groupBy('equipo_id')
            ->groupBy('norma')
            ->groupBy('partida')
            ->groupBy('clave_id')
            ->with([
                'dep_perf' => function($dp) {
                    $dp ->withTrashed()
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
                    -> select('id', 'nompro', 'tipo', 'operacion', 'proceso_id');
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
            ->get();
        }
        $carga = carga::where('departamento_id', '=', $request->departamento_id)
            ->where('fecha', 'LIKE', '%'.$request->mes.'%')
            ->whereNotNull('clave_id')
            ->where('partida', '!=', 'N/A')
            ->whereHas('proceso', function($q){
                $q->where('tipo', '!=', '3');
            })
            ->selectRaw('norma, proceso_id, departamento_id, SUM(valor) AS valor')
            ->groupBy('proceso_id')
            ->groupBy('norma')
            ->groupBy('departamento_id')
            ->with([
                'dep_perf' => function($dp) {
                    $dp ->withTrashed()
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
                    -> select('id', 'nompro', 'tipo', 'operacion', 'proceso_id');
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
            ->get();*/
        return $carga;
    }

    //consulta para los paros
    public function ConParo(Request $request){
        if ($request->tipo == 'dia') {
            //paros
            $paros = parosCarga::where('departamento_id', '=', $request->departamento_id)
            ->whereBetween('fecha', [$request->iniDia, $request->finDia])
            ->with([
                'sub_paro' => function($spa){
                    $spa->select('id', 'fecha', 'iniFecha', 'orden', 'estatus', 'descri', 'finFecha', 'tiempo','paro_id', 'perfil_ini_id','perfil_fin_id', 'maq_pro_id', 'proceso_id', 'pla_acci', 'paros_carga_id', 'departamento_id')
                    ->orderBy('id','desc');
                },
                'paros' => function($pr){
                    $pr->select('id', 'clave', 'descri', 'tipo');
                },
                'perfil_ini' => function($pini){
                    $pini->select('id', 'Nombre', 'ApPat', 'ApMat');
                },
                'perfil_fin' => function($pfin){
                    $pfin->select('id', 'Nombre', 'ApPat', 'ApMat');
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
            ->get(['id', 'fecha', 'iniFecha', 'orden', 'estatus', 'descri', 'finFecha', 'tiempo','paro_id', 'perfil_ini_id','perfil_fin_id', 'maq_pro_id', 'proceso_id', 'pla_acci', 'paros_carga_id', 'departamento_id']);
        }
        elseif ($request->tipo == 'rango') {
            $paros = parosCarga::where('departamento_id', '=', $request->departamento_id)
            ->whereBetween('fecha', [$request->iniDia, $request->finDia])
            ->selectRaw('proceso_id, paro_id, maq_pro_id, SUM(tiempo) AS tiempo')
            ->groupBy('departamento_id')
            ->groupBy('proceso_id')
            ->groupBy('paro_id')
            ->groupBy('maq_pro_id')
            ->with([
                'sub_paro' => function($spa){
                    $spa->select('id', 'fecha', 'iniFecha', 'orden', 'estatus', 'descri', 'finFecha', 'tiempo','paro_id', 'perfil_ini_id','perfil_fin_id', 'maq_pro_id', 'proceso_id', 'pla_acci', 'paros_carga_id', 'departamento_id')
                    ->orderBy('id','desc');
                },
                'paros' => function($pr){
                    $pr->select('id', 'clave', 'descri', 'tipo');
                },
                'perfil_ini' => function($pini){
                    $pini->select('id', 'Nombre', 'ApPat', 'ApMat');
                },
                'perfil_fin' => function($pfin){
                    $pfin->select('id', 'Nombre', 'ApPat', 'ApMat');
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
            ->get();
        }
        elseif ($request->tipo == 'mes') {
            $paros = parosCarga::where('departamento_id', '=', $request->departamento_id)
            ->where('fecha', 'LIKE', '%'.$request->mes.'%')
            ->selectRaw('proceso_id, paro_id, maq_pro_id, SUM(tiempo) AS tiempo')
            ->groupBy('departamento_id')
            ->groupBy('proceso_id')
            ->groupBy('paro_id')
            ->groupBy('maq_pro_id')
            ->with([
                'sub_paro' => function($spa){
                    $spa->select('id', 'fecha', 'iniFecha', 'orden', 'estatus', 'descri', 'finFecha', 'tiempo','paro_id', 'perfil_ini_id','perfil_fin_id', 'maq_pro_id', 'proceso_id', 'pla_acci', 'paros_carga_id', 'departamento_id')
                    ->orderBy('id','desc');
                },
                'paros' => function($pr){
                    $pr->select('id', 'clave', 'descri', 'tipo');
                },
                'perfil_ini' => function($pini){
                    $pini->select('id', 'Nombre', 'ApPat', 'ApMat');
                },
                'perfil_fin' => function($pfin){
                    $pfin->select('id', 'Nombre', 'ApPat', 'ApMat');
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
            ->get();
        }

        return $paros;
    }

    //consulta graficas guardadas
    public function ConGrafi(Request $request){
        $grafi = pac_grafica::where('departamento_id', '=', $request->departamento_id)
        ->with([
            'grafi_arrs' => function($ga){
                $ga->select('id', 'tipo', 'pac_grafica_id', 'material_id', 'maq_pro_id', 'proceso_id', 'maq_pro_linea_id', 'proceso_linea_id');
            }
        ])
        ->orderBy('graTipo', 'desc')
        ->get(['id', 'graTipo', 'propa', 'rango', 'subDe', 'subIz', 'subtitulo', 'tipo', 'tipoParo', 'titulo']);
        return $grafi;
    }

    //grafica de pastel
    public function PaiGrafi(Request $request){
        if ($request->tipo == 'generalMaq') {
            $carga = carga::where('departamento_id', '=', $request->departamento_id)
            ->whereBetween('fecha', [$request->iniDia, $request->finDia])
            ->whereNotNull('clave_id')
            ->whereIn('maq_pro_id', $request->maquinas)
            ->where('partida', '!=', 'N/A')
            ->selectRaw('proceso_id, maq_pro_id, departamento_id, SUM(valor) AS valor')
            ->groupBy('departamento_id')
            ->groupBy('proceso_id')
            ->groupBy('maq_pro_id')
            ->orderBy('proceso_id','asc')
            ->with([
                'dep_perf' => function($dp) {
                    $dp ->withTrashed()
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
                    -> select('id', 'nompro', 'tipo', 'operacion', 'proceso_id');
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
            ->get();
        }
        elseif ($request->tipo == 'generalTot') {
            $carga = carga::where('departamento_id', '=', $request->departamento_id)
            ->whereBetween('fecha', [$request->iniDia, $request->finDia])
            ->whereIn('proceso_id', $request->proceso)
            ->selectRaw('proceso_id, departamento_id, SUM(valor) AS valor')
            ->groupBy('departamento_id')
            ->groupBy('proceso_id')
            ->orderBy('proceso_id','asc')
            ->with([
                'dep_perf' => function($dp) {
                    $dp ->withTrashed()
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
                    -> select('id', 'nompro', 'tipo', 'operacion', 'proceso_id');
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
            ->get();
        }
        elseif ($request->tipo == 'norma') {
            $carga = carga::where('departamento_id', '=', $request->departamento_id)
            ->whereBetween('fecha', [$request->iniDia, $request->finDia])
            ->whereNotNull('clave_id')
            ->where('partida', '!=', 'N/A')
            //->whereIn('proceso_id', $request->proceso)
            ->whereIn('maq_pro_id', $request->maquinas)
            ->whereIn('norma', $request->norma)
            ->selectRaw('proceso_id, maq_pro_id, norma, departamento_id, SUM(valor) AS valor')
            ->groupBy('departamento_id')
            ->groupBy('proceso_id')
            ->groupBy('maq_pro_id')
            ->groupBy('norma')
            ->with([
                'dep_perf' => function($dp) {
                    $dp ->withTrashed()
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
                    -> select('id', 'nompro', 'tipo', 'operacion', 'proceso_id');
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
            ->get();
        }
        elseif ($request->tipo == 'catego') {
            $carga = carga::join('claves', 'claves.id', '=', 'cargas.clave_id')
            ->where('cargas.departamento_id', '=', $request->departamento_id)
            ->whereBetween('cargas.fecha', [$request->iniDia, $request->finDia])
            ->whereNotNull('cargas.clave_id')
            ->where('cargas.partida', '!=', 'N/A')
            //->whereIn('cargas.proceso_id', $request->proceso)
            ->whereIn('cargas.maq_pro_id', $request->maquinas)
            ->selectRaw('claves.categoria, cargas.departamento_id, SUM(cargas.valor) AS valor')
            ->groupBy('departamento_id')
            //->groupBy('proceso_id')
            //->groupBy('maq_pro_id')
            ->groupBy('claves.categoria')
            ->with([
                'dep_perf' => function($dp) {
                    $dp ->withTrashed()
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
                    -> select('id', 'nompro', 'tipo', 'operacion', 'proceso_id');
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
                    -> select('id', 'CVE_ART', 'DESCR', 'categoria');
                },
                'notas' => function($not){
                    $not ->withTrashed()
                    -> latest()
                    -> select('id', 'fecha', 'nota', 'carga_id');
                }
            ])
            ->get();
        }
        elseif ($request->tipo == 'partida') {
            $carga = carga::where('departamento_id', '=', $request->departamento_id)
            ->whereBetween('fecha', [$request->iniDia, $request->finDia])
            ->whereNotNull('clave_id')
            ->where('partida', '!=', 'N/A')
            //->whereIn('proceso_id', $request->proceso)
            ->whereIn('maq_pro_id', $request->maquinas)
            ->selectRaw('clave_id, maq_pro_id, partida, norma, proceso_id, departamento_id, SUM(valor) AS valor')
            ->groupBy('departamento_id')
            ->groupBy('proceso_id')
            ->groupBy('maq_pro_id')
            ->groupBy('norma')
            ->groupBy('partida')
            ->groupBy('clave_id')
            ->with([
                'dep_perf' => function($dp) {
                    $dp ->withTrashed()
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
                    -> select('id', 'nompro', 'tipo', 'operacion', 'proceso_id');
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
            ->get();
        }
        elseif ($request->tipo == 'equipo') {
            $carga = carga::where('departamento_id', '=', $request->departamento_id)
            ->whereBetween('fecha', [$request->iniDia, $request->finDia])
            ->whereNotNull('clave_id')
            ->where('partida', '!=', 'N/A')
            //->whereIn('proceso_id', $request->proceso)
            ->whereIn('maq_pro_id', $request->maquinas)
            ->selectRaw('equipo_id, maq_pro_id, turno_id, proceso_id, departamento_id, SUM(valor) AS valor')
            ->groupBy('departamento_id')
            ->groupBy('proceso_id')
            ->groupBy('maq_pro_id')
            ->groupBy('equipo_id')
            ->groupBy('turno_id')
            ->with([
                'dep_perf' => function($dp) {
                    $dp ->withTrashed()
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
                    -> select('id', 'nompro', 'tipo', 'operacion', 'proceso_id');
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
            ->get();
        }
        elseif ($request->tipo == 'efiTur') {
            $carga = carga::where('departamento_id', '=', $request->departamento_id)
            ->whereBetween('fecha', [$request->iniDia, $request->finDia])
            ->whereIn('proceso_id', $request->proceso)
            ->selectRaw('equipo_id, proceso_id, departamento_id, (SUM(valor) / COUNT(valor)) AS valor')
            ->groupBy('departamento_id')
            ->groupBy('proceso_id')
            ->groupBy('equipo_id')
            ->with([
                'dep_perf' => function($dp) {
                    $dp ->withTrashed()
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
                    -> select('id', 'nompro', 'tipo', 'operacion', 'proceso_id');
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
            ->get();
        }
        elseif ($request->tipo == 'efiDia') {
            # code...
        }

        return $carga;
    }

    //grafica paros de pastel
    public function PrPaiGrafi(Request $request){
        if ($request->tipoParo == 'total') {
            # code...
            $paros = parosCarga::where('departamento_id', '=', $request->departamento_id)
            ->whereBetween('fecha', [$request->iniDia, $request->finDia])
            ->whereIn('maq_pro_id', $request->maquinas)
            //->whereIn('paro_id', $request->paros)
            ->selectRaw('paro_id, SUM(tiempo) AS tiempo')
            //->groupBy('proceso_id')
            //->groupBy('maq_pro_id')
            ->groupBy('paro_id')
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
            ->get();
        }else{
            $paros = parosCarga::where('departamento_id', '=', $request->departamento_id)
            ->whereBetween('fecha', [$request->iniDia, $request->finDia])
            ->whereIn('maq_pro_id', $request->maquinas)
            //->whereIn('paro_id', $request->paros)
            ->selectRaw('proceso_id, maq_pro_id, paro_id, SUM(tiempo) AS tiempo')
            ->groupBy('proceso_id')
            ->groupBy('maq_pro_id')
            ->groupBy('paro_id')
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
            ->get();
        }
        return $paros;
    }

    //grafica de punto o barra
    public function LinGrafi(Request $request){
        if ($request->rango == 1) {
            $tipFec = 'DATE_FORMAT(fecha, "%Y-%m-%d")';
        }elseif ($request->rango == 2) {
            $tipFec = 'DATE_FORMAT(fecha, "%Y-%m")';
        }elseif ($request->rango == 3){
            $tipFec = 'semana';
        }else{
            $tipFec = 'DATE_FORMAT(fecha, "%Y")';
        }

        if ($request->tipo == 'generalMaq') {
            $carga = carga::where('departamento_id', '=', $request->departamento_id)
            ->selectRaw($tipFec.' AS fec, maq_pro_id, proceso_id, departamento_id, SUM(valor) AS valor')
            ->whereNotNull('clave_id')
            ->whereIn('maq_pro_id', $request->maquinas)
            ->where('partida', '!=', 'N/A')
            ->whereRaw($tipFec.' BETWEEN "'.$request->iniDia.'" AND "'.$request->finDia.'"')
            ->groupBy('departamento_id')
            ->groupBy('maq_pro_id')
            ->groupBy('fec')
            ->groupBy('proceso_id')
            ->with([
                'dep_perf' => function($dp) {
                    $dp ->withTrashed()
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
                    -> select('id', 'nompro', 'tipo', 'operacion', 'proceso_id');
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
            ->get();
        }
        elseif ($request->tipo == 'generalTot') {
            $carga = carga::where('departamento_id', '=', $request->departamento_id)
            ->selectRaw($tipFec.' AS fec, maq_pro_id, proceso_id, departamento_id, SUM(valor) AS valor')
            ->whereIn('proceso_id', $request->proceso)
            ->whereRaw($tipFec.' BETWEEN "'.$request->iniDia.'" AND "'.$request->finDia.'"')
            ->groupBy('departamento_id')
            ->groupBy('maq_pro_id')
            ->groupBy('fec')
            ->groupBy('proceso_id')
            ->with([
                'dep_perf' => function($dp) {
                    $dp ->withTrashed()
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
                    -> select('id', 'nompro', 'tipo', 'operacion', 'proceso_id');
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
            ->get();
        }
        return $carga;
    }

    //grafica de pastel por rango para combinada
    public function PaiGrafiRan(Request $request){
        if ($request->rango == 1) {
            $tipFec = 'DATE_FORMAT(fecha, "%Y-%m-%d")';
        }elseif ($request->rango == 2) {
            $tipFec = 'DATE_FORMAT(fecha, "%Y-%m")';
        }elseif ($request->rango == 3){
            $tipFec = 'semana';
        }else{
            $tipFec = 'DATE_FORMAT(fecha, "%Y")';
        }

        if ($request->tipo == 'generalMaq') {
            $carga = carga::where('departamento_id', '=', $request->departamento_id)
            ->selectRaw('maq_pro_id, proceso_id, departamento_id, SUM(valor) AS valor')
            ->whereNotNull('clave_id')
            ->whereIn('maq_pro_id', $request->maquinas)
            ->where('partida', '!=', 'N/A')
            ->whereRaw($tipFec.' BETWEEN "'.$request->iniDia.'" AND "'.$request->finDia.'"')
            ->groupBy('departamento_id')
            ->groupBy('proceso_id')
            ->groupBy('maq_pro_id')
            ->orderBy('proceso_id','asc')
            ->with([
                'dep_perf' => function($dp) {
                    $dp ->withTrashed()
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
                    -> select('id', 'nompro', 'tipo', 'operacion', 'proceso_id');
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
            ->get();
        }
        elseif ($request->tipo == 'generalTot') {
            $carga = carga::where('departamento_id', '=', $request->departamento_id)
            ->selectRaw('maq_pro_id, proceso_id, departamento_id, SUM(valor) AS valor')
            ->whereIn('proceso_id', $request->proceso)
            ->whereRaw($tipFec.' BETWEEN "'.$request->iniDia.'" AND "'.$request->finDia.'"')
            ->groupBy('departamento_id')
            ->groupBy('maq_pro_id')
            ->groupBy('proceso_id')
            ->orderBy('proceso_id','asc')
            ->with([
                'dep_perf' => function($dp) {
                    $dp ->withTrashed()
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
                    -> select('id', 'nompro', 'tipo', 'operacion', 'proceso_id');
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
            ->get();
        }
        return $carga;
    }

    //Guardado de graficas
    public function SaveGrafi(Request $request){
        $sutitu = empty($request->subtitulo) ? '' : $request->subtitulo;
        $subIz = empty($request->subIz) ? '' : $request->subIz;
        $subDe = empty($request->subDe) ? '' : $request->subDe;
        $nuGrafi = pac_grafica::create([
            'graTipo' => $request->graTipo,
            'titulo' => $request->titulo,
            'subtitulo' => $sutitu,
            'subIz' => $subIz,
            'subDe' => $subDe,
            'rango' => $request->rango,
            'propa' => $request->propa,
            'tipo' => $request->tipo,
            'tipoParo' => $request->tipoParo,
            'departamento_id' => $request->departamento_id
        ]);

        //recorrido de maquinas
        if (!empty($request->maquinas)) {
            foreach ($request->maquinas as $maq) {
                grafi_arr::create([
                    'tipo' => $request->tipo,
                    'pac_grafica_id' => $nuGrafi->id,
                    'maq_pro_id' => $maq
                ]);
            }
        }

        //recorrido de maquinas barra
        if (!empty($request->maquinasBar)) {
            foreach ($request->maquinasBar as $maq) {
                grafi_arr::create([
                    'tipo' => $request->tipo,
                    'pac_grafica_id' => $nuGrafi->id,
                    'maq_pro_id' => $maq
                ]);
            }
        }

        //recorrido de maquina linea
        if (!empty($request->maquinasLin)) {
            foreach ($request->maquinasLin as $maq) {
                grafi_arr::create([
                    'tipo' => $request->tipo,
                    'pac_grafica_id' => $nuGrafi->id,
                    'maq_pro_linea_id' => $maq
                ]);
            }
        }

        //recorrido de procesos
        if (!empty($request->procesos)) {
            foreach ($request->procesos as $pro) {
                grafi_arr::create([
                    'tipo' => $request->tipo,
                    'pac_grafica_id' => $nuGrafi->id,
                    'proceso_id' => $pro
                ]);
            }
        }

        //recorrrido de procesos de para barra
        if (!empty($request->procesosBar)) {
            foreach ($request->procesosBar as $pro) {
                grafi_arr::create([
                    'tipo' => $request->tipo,
                    'pac_grafica_id' => $nuGrafi->id,
                    'proceso_id' => $pro
                ]);
            }
        }

        //recorrido de procesos para lineas
        if (!empty($request->procesosLin)) {
            foreach ($request->procesosLin as $pro) {
                grafi_arr::create([
                    'tipo' => $request->tipo,
                    'pac_grafica_id' => $nuGrafi->id,
                    'proceso_linea_id' => $pro
                ]);
            }
        }

        //recorrdio de normas
        if (!empty($request->norma)) {
            foreach ($request->norma as $nor) {
                grafi_arr::create([
                    'tipo' => $request->tipo,
                    'pac_grafica_id' => $nuGrafi->id,
                    'material_id' => $nor
                ]);
            }
        }

        return $request;
    }

    //Actualizar graficas guardadas
    public function UpdateGrafi(Request $request){
        $sutitu = empty($request->subtitulo) ? '' : $request->subtitulo;
        $subIz = empty($request->subIz) ? '' : $request->subIz;
        $subDe = empty($request->subDe) ? '' : $request->subDe;
        pac_grafica::find($request->id)->update([
            'titulo' => $request->titulo,
            'subtitulo' => $sutitu,
            'subIz' => $subIz,
            'subDe' => $subDe,
            'rango' => $request->rango,
            'propa' => $request->propa,
            'tipo' => $request->tipo,
            'tipoParo' => $request->tipoParo
        ]);

        //eliminar maquinas
        if (!empty($request->Nmaquinas)) {
            foreach ($request->Nmaquinas as $dele) {
                if (!in_array($dele, $request->maquinas)) {
                    grafi_arr::where('pac_grafica_id', '=', $request->id)
                    ->where('maq_pro_id', '=', $dele)
                    ->delete();
                }
            }
        }

        //agrega maquinas
        if (!empty($request->maquinas)) {

            foreach ($request->maquinas as $maq) {
                if (!in_array($maq, $request->Nmaquinas)) {
                    $ver = grafi_arr::where('pac_grafica_id', '=', $request->id)
                    ->where('maq_pro_id', '=', $maq)
                    ->first();
                    //print($ver);

                    if (!empty($ver)) {
                        $ver->restore();
                    }else{
                        grafi_arr::create([
                            'tipo' => $request->tipo,
                            'pac_grafica_id' => $request->id,
                            'maq_pro_id' => $maq
                        ]);
                    }
                }
            }

        }

        //eliminar maquinas barra combinado
        if (!empty($request->NmaquinasBar)) {
            foreach ($request->NmaquinasBar as $dele) {
                if (!in_array($dele, $request->maquinasBar)) {
                    grafi_arr::where('pac_grafica_id', '=', $request->id)
                    ->where('maq_pro_id', '=', $dele)
                    ->delete();
                    //print('$dele');
                }
            }
        }

        //Agregar maquinas barra combinado
        if (!empty($request->maquinasBar)) {

            foreach ($request->maquinasBar as $maq) {
                if (!in_array($maq, $request->NmaquinasBar)) {
                    $ver1 = grafi_arr::where('pac_grafica_id', '=', $request->id)
                    ->where('maq_pro_id', '=', $dele)
                    ->first();

                    if (!empty($ver1)) {
                        $ver1->restore();
                    }else{
                        grafi_arr::create([
                            'tipo' => $request->tipo,
                            'pac_grafica_id' => $request->id,
                            'maq_pro_id' => $maq
                        ]);
                    }
                }
            }

        }

        //eliminar maquinas Linea combinado
        if (!empty($request->NmaquinasLin)) {
            foreach ($request->NmaquinasLin as $dele) {
                if (!in_array($dele, $request->maquinasBar)) {
                    grafi_arr::where('pac_grafica_id', '=', $request->id)
                    ->where('maq_pro_linea_id', '=', $dele)
                    ->delete();
                }
            }
        }

        //Agregar de maquina linea combinado
        if (!empty($request->maquinasLin)) {
            foreach ($request->maquinasLin as $maq) {
                if (!in_array($maq, $request->NmaquinasBar)) {
                    $ver3 = grafi_arr::where('pac_grafica_id', '=', $request->id)
                    ->where('maq_pro_linea_id', '=', $maq)
                    ->first();

                    if (!empty($ver3)) {
                        $ver3->restore();
                    }else{
                        grafi_arr::create([
                            'tipo' => $request->tipo,
                            'pac_grafica_id' => $request->id,
                            'maq_pro_linea_id' => $maq
                        ]);
                    }
                }
            }
        }

        //eliminar procesos
        if (!empty($request->Nprocesos)) {
            foreach ($request->Nprocesos as $dele) {
                if (!in_array($dele, $request->procesos)) {
                    grafi_arr::where('pac_grafica_id', '=', $request->id)
                    ->where('proceso_id', '=', $dele)
                    ->delete();
                }
            }
        }

        //Agregar de procesos
        if (!empty($request->procesos)) {
            foreach ($request->procesos as $pro) {
                if (!in_array($pro, $request->Nprocesos)) {
                    $ver4 = grafi_arr::where('pac_grafica_id', '=', $request->id)
                    ->where('proceso_id', '=', $pro)
                    ->first();

                    if (!empty($ver4)) {
                        $ver4->restore();
                    }else{
                        grafi_arr::create([
                            'tipo' => $request->tipo,
                            'pac_grafica_id' => $request->id,
                            'proceso_id' => $pro
                        ]);
                    }
                }
            }
        }

        //eliminar procesos barra combinado
        if (!empty($request->NprocesosBar)) {
            foreach ($request->NprocesosBar as $dele) {
                if (!in_array($dele, $request->procesosBar)) {
                    grafi_arr::where('pac_grafica_id', '=', $request->id)
                    ->where('proceso_id', '=', $dele)
                    ->delete();
                }
            }
        }

        //Agregar procesos para barra combinado
        if (!empty($request->procesosBar)) {
            foreach ($request->procesosBar as $pro) {
                if (!in_array($pro, $request->NprocesosBar)) {
                    $ver5 = grafi_arr::where('pac_grafica_id', '=', $request->id)
                    ->where('proceso_id', '=', $pro)
                    ->first();

                    if (!empty($ver5)) {
                        $ver5->restore();
                    }else{
                        grafi_arr::create([
                            'tipo' => $request->tipo,
                            'pac_grafica_id' => $request->id,
                            'proceso_id' => $pro
                        ]);
                    }
                }
            }
        }

        //eliminar procesos barra combinado
        if (!empty($request->NprocesosLin)) {
            foreach ($request->NprocesosLin as $dele) {
                if (!in_array($dele, $request->procesosLin)) {
                    grafi_arr::where('pac_grafica_id', '=', $request->id)
                    ->where('proceso_linea_id', '=', $dele)
                    ->delete();
                }
            }
        }

        //agregar procesos para lineas combinado
        if (!empty($request->procesosLin)) {
            foreach ($request->procesosLin as $pro) {
                if (!in_array($pro, $request->NprocesosLin)) {
                    $ver6 = grafi_arr::where('pac_grafica_id', '=', $request->id)
                    ->where('proceso_linea_id', '=', $pro)
                    ->first();

                    if (!empty($ver6)) {
                        $ver6->restore();
                    }else{
                        grafi_arr::create([
                            'tipo' => $request->tipo,
                            'pac_grafica_id' => $request->id,
                            'proceso_linea_id' => $pro
                        ]);
                    }
                }
            }
        }

        //eliminar normas
        if (!empty($request->Nnorma)) {
            foreach ($request->Nnorma as $dele) {
                if (!in_array($dele, $request->norma)) {
                    grafi_arr::where('pac_grafica_id', '=', $request->id)
                    ->where('material_id', '=', $dele)
                    ->delete();
                }
            }
        }

        //recorrdio de normas
        if (!empty($request->norma)) {
            foreach ($request->norma as $nor) {
                if (!in_array($nor, $request->Nnorma)) {
                    $ver7 = grafi_arr::where('pac_grafica_id', '=', $request->id)
                    ->where('material_id', '=', $nor)
                    ->first();

                    if (!empty($ver7)) {
                        $ver7->restore();
                    }else{
                        grafi_arr::create([
                            'tipo' => $request->tipo,
                            'pac_grafica_id' => $request->id,
                            'material_id' => $nor
                        ]);
                    }
                }
            }
        }

        return $request;
    }

    //Elimina las graficas guardadas
    public function ElimiGra(Request $request){
        pac_grafica::find($request->id)->delete();
        return $request;
    }

    public function destroy(Request $request, carga $carga){
        //
        foreach ($request->elimiMasi as $eli) {
            //print($eli.' - ');
            carga::find($eli)->delete();
        }
        //return $request;
        return redirect()->back()
            ->with('message', 'Post Updated Successfully.');
    }
}
