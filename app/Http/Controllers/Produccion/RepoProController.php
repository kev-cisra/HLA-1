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
        $carga = [];
        $mate = [];
        $procesos = [];
        $paros = [];
        $claParo = [];
        $Maqui = [];

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

         /**************************** consulta si existe la busqueda  ****************************************************/
        if (!empty($request->busca)) {
             //carga
            $año = empty($request->ano) ? date('Y') : $request->ano;
            $bus = $request->busca;
            $carga = carga::where('departamento_id', '=', $bus)
            ->where('semana', 'LIKE', '%'.$año.'%')
            ->with([
                'dep_perf' => function($dp) use($bus) {
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
                    -> select('id', 'CVE_ART', 'DESCR', 'UNI_MED');
                },
                'notas' => function($not){
                    $not ->withTrashed()
                    -> latest()
                    -> select('id', 'fecha', 'nota', 'carga_id');
                }
            ])
            ->get(['id','fecha','semana','valor','partida','notaPen','equipo_id','dep_perf_id','per_carga','maq_pro_id','proceso_id','norma','clave_id','turno_id','VerInv', 'departamento_id']);

            //paros
            $paros = parosCarga::where('departamento_id', '=', $bus)
            ->where('fecha', 'LIKE', '%'.$año.'%')
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

            $claParo = paros::get();

            //procesos
            $procesos = procesos::where('departamento_id', '=', $request->busca)
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
                'formulas.maq_pros.maquinas' => function($fa){
                    $fa->select('id', 'Nombre', 'departamento_id');
                },
            ])
            ->get();

            //Maquinas
            $Maqui = Maquinas::where('departamento_id', '=', $request->busca)
            ->with([
                'marca' => function($mar) {
                    $mar -> select('id', 'Nombre', 'maquinas_id');
                }
            ])
            ->get(['id', 'Nombre', 'departamento_id']);

        }

        return Inertia::render('Produccion/Reportes/RProduccion', ['usuario' => $perf, 'depa' => $depa, 'cargas' => $carga, 'materiales' => $mate, 'procesos' => $procesos, 'paros' => $paros, 'claParo' => $claParo, 'maquinas' => $Maqui]);
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
