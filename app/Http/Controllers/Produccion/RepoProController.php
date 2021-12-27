<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\Maquinas;
use App\Models\Produccion\carga;
use App\Models\Produccion\catalogos\procesos;
use App\Models\Produccion\dep_mat;
use App\Models\Produccion\paros;
use App\Models\Produccion\parosCarga;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function index(Request $request)
    {
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

    public function ConProdu(Request $request){
        if ($request->tipo == 'dia') {
            //$addDia = date("Y-m-d H:m:s" , strtotime($request->iniDia."+ 1 days"));
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
        elseif ($request->tipo == 'rango') {
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
        return $carga;
    }

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

    public function PaiGrafi(Request $request){
        if ($request->tipo == 'general') {
            $carga = carga::where('departamento_id', '=', $request->departamento_id)
            ->whereBetween('fecha', [$request->iniDia, $request->finDia])
            ->whereNotNull('clave_id')
            ->whereIn('proceso_id', $request->proceso)
            ->where('partida', '!=', 'N/A')
            ->selectRaw('proceso_id, departamento_id, SUM(valor) AS valor')
            ->groupBy('departamento_id')
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
        elseif ($request->tipo == 'norma') {
            $carga = carga::where('departamento_id', '=', $request->departamento_id)
            ->whereBetween('fecha', [$request->iniDia, $request->finDia])
            ->whereNotNull('clave_id')
            ->where('partida', '!=', 'N/A')
            ->whereIn('proceso_id', $request->proceso)
            ->whereIn('norma', $request->norma)
            ->selectRaw('proceso_id, norma, departamento_id, SUM(valor) AS valor')
            ->groupBy('departamento_id')
            ->groupBy('proceso_id')
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
        elseif ($request->tipo == 'partida') {
            $carga = carga::where('departamento_id', '=', $request->departamento_id)
            ->whereBetween('fecha', [$request->iniDia, $request->finDia])
            ->whereNotNull('clave_id')
            ->where('partida', '!=', 'N/A')
            ->whereIn('proceso_id', $request->proceso)
            ->selectRaw('clave_id, partida, norma, proceso_id, departamento_id, SUM(valor) AS valor')
            ->groupBy('departamento_id')
            ->groupBy('proceso_id')
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
            ->whereIn('proceso_id', $request->proceso)
            ->selectRaw('equipo_id, turno_id, proceso_id, departamento_id, SUM(valor) AS valor')
            ->groupBy('departamento_id')
            ->groupBy('proceso_id')
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

        return $carga;
    }

    public function LinGrafi(Request $request){
        if ($request->rango == 1) {
            $tipFec = "%Y-%m-%d";
        }elseif ($request->rango == 2) {
            $tipFec = "%Y-%m";
        }else{
            $tipFec = "%Y";
        }

        if ($request->tipo == 'general') {
            $carga = carga::where('departamento_id', '=', $request->departamento_id)
            ->selectRaw('DATE_FORMAT(fecha, "'.$tipFec.'") AS fec, proceso_id, departamento_id, SUM(valor) AS valor')
            ->whereNotNull('clave_id')
            ->whereIn('proceso_id', $request->proceso)
            ->where('partida', '!=', 'N/A')
            ->whereRaw('DATE_FORMAT(fecha, "'.$tipFec.'") BETWEEN "'.$request->iniDia.'" AND "'.$request->finDia.'"')
            ->groupBy('departamento_id')
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
        elseif ($request->tipo == 'norma') {
            $carga = carga::where('departamento_id', '=', $request->departamento_id)
            ->whereNotNull('clave_id')
            ->where('partida', '!=', 'N/A')
            ->whereIn('proceso_id', $request->proceso)
            ->whereIn('norma', $request->norma)
            ->selectRaw('DATE_FORMAT(fecha, "'.$tipFec.'") AS fec, proceso_id, norma, departamento_id, SUM(valor) AS valor')
            ->whereRaw('DATE_FORMAT(fecha, "'.$tipFec.'") BETWEEN "'.$request->iniDia.'" AND "'.$request->finDia.'"')
            ->groupBy('fec')
            ->groupBy('departamento_id')
            ->groupBy('proceso_id')
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
        elseif ($request->tipo == 'partida') {
            $carga = carga::where('departamento_id', '=', $request->departamento_id)
            ->whereNotNull('clave_id')
            ->where('partida', '!=', 'N/A')
            ->whereIn('proceso_id', $request->proceso)
            ->selectRaw('DATE_FORMAT(fecha, "'.$tipFec.'") AS fec, clave_id, partida, norma, proceso_id, departamento_id, SUM(valor) AS valor')
            ->whereRaw('DATE_FORMAT(fecha, "'.$tipFec.'") BETWEEN "'.$request->iniDia.'" AND "'.$request->finDia.'"')
            ->groupBy('fec')
            ->groupBy('departamento_id')
            ->groupBy('proceso_id')
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
            ->whereNotNull('clave_id')
            ->where('partida', '!=', 'N/A')
            ->whereIn('proceso_id', $request->proceso)
            ->selectRaw('DATE_FORMAT(fecha, "'.$tipFec.'") AS fec, equipo_id, turno_id, proceso_id, departamento_id, SUM(valor) AS valor')
            ->whereRaw('DATE_FORMAT(fecha, "'.$tipFec.'") BETWEEN "'.$request->iniDia.'" AND "'.$request->finDia.'"')
            ->groupBy('departamento_id')
            ->groupBy('proceso_id')
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
        return $carga;
    }

    public function destroy(Request $request, carga $carga)
    {
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
