<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\obje_cordi;
use App\Models\Produccion\AbaEntregas;
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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;

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

        if (count($perf->dep_pers) != 0) {
            //muestran los departamentos
            $depa = $perf->dep_pers;
        }else{
            //consulta el id de la area produccion
            $iddeppro = Departamentos::where('Nombre', '=', 'OPERACIONES')
                ->first();
            //muestra las areas y sub areas de produccion
            $depa = Departamentos::where('departamento_id', '=', $iddeppro->id)
                ->with('sub_Departamentos')
                ->get(['id', 'IdUser', 'Nombre', 'departamento_id']);
        }

        return Inertia::render('Produccion/Carga', ['usuario' => $perf, 'depa' => $depa]);

    }

    public function CarProdu(Request $request){
        $hoy = date('Y-m-d');
        $dia = date("Y-m-d",strtotime($hoy."- 1 days")).' 19:00:00';
        $mañana = date("Y-m-d",strtotime($hoy."+ 1 days")).' 07:00:00';
        //carga
        $carga = carga::where('departamento_id', '=', $request->departamento_id)
        ->whereBetween('fecha', [$dia, $mañana])
        ->orWhere(function($q) use ($dia){
            $q->whereDate('fecha', '<=', $dia)
            ->where('notaPen', '=', '2');
        })
        ->with([
            'dep_perf' => function($dp){
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
        return $carga;
    }

    public function CarOperador(Request $request){
        //Paquetes de operador
        $carOpe = carOpe::where('departamento_id', '=', $request->departamento_id)
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
        return $carOpe;
    }

    public function CarNorma(Request $request){
        //Paquete Normas Claves y partida
        $carNor = carNorm::where('departamento_id', '=', $request->departamento_id)
        ->with([
            'dep_mat' => function($dm){
                $dm -> select('id', 'departamento_id', 'material_id');
            },
            'dep_mat.materiales' => function($mat){
                $mat->select('id','idmat', 'nommat');
            },
            'clave' => function($cla){
                $cla -> select('id', 'CVE_ART', 'DESCR', 'UNI_MED', 'dep_mat_id');
            },
            'abapar' => function($par){
                $par -> select('id', 'folio', 'banco', 'partida' );
            }
        ])
        ->get(['id', 'partida', 'estatus', 'norma', 'clave_id', 'partida_id', 'departamento_id']);
        return $carNor;
    }

    public function CarObje(Request $request){
        $par = AbaEntregas::where('depa_entrega', '=', $request->departamento_id)
        ->where('esta_final', '=', 'Activo')
        ->get();

        $nu = [];
        if (!empty($par)) {
            foreach ($par as $p) {
                array_push($nu, $p->clave_id);
            }
        }

        //return $par;

        //Paquetes Objetivos
        $objetivos = obje_cordi::where('departamento_id', '=', $request->departamento_id)
        ->whereIn('clave_id', $nu)
        ->with([
            'proceso' => function($pro) {
                $pro -> select('id', 'nompro', 'proceso_id');
            },
            'proceso.proceso_sub' => function($pp) {
                $pp -> select('id', 'nompro', 'proceso_id');
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
        ->get(['id', 'estatus', 'pro_hora', 'proceso_id', 'maq_pro_id', 'norma', 'clave_id', 'departamento_id']);
        return $objetivos;
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;

        Validator::make($request->all(), [
            'proceso_id' => ['required'],
            'dep_perf_id' => ['required'],
            'valor' => ['required']
        ])->validate();
        $hoy = Carbon::now();
        $ofec = new Carbon($request->fecha);
        $fecha = $hoy->format('Y-m-d') != $ofec->format('Y-m-d') ? $request->fecha : $hoy->toDateTimeString();
        carga::create([
            'fecha' => $fecha,
            'semana' => $request->semana,
            'per_carga' => $request->per_carga,
            'proceso_id' => $request->proceso_id,
            'dep_perf_id' => $request->dep_perf_id,
            'maq_pro_id' => $request->maq_pro_id,
            'partida_id' => $request->partida,
            'partida' => $request->p_nom,
            'valor' => $request->valor,
            'norma' => $request->norma,
            'equipo_id' => $request->equipo_id,
            'clave_id' => $request->clave_id,
            'turno_id' => $request->turno_id,
            'notaPen' => $request->notaPen,
            'departamento_id' => $request->departamento_id,
            'VerInv' => $request->VerInv
        ]);


        return redirect()->back()
            ->with('message', 'Post Created Successfully.');
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
