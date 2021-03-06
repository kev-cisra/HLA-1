<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\Maquinas;
use App\Models\Produccion\carga;
use App\Models\Produccion\catalogos\procesos;
use App\Models\Produccion\dep_mat;
use App\Models\Produccion\dep_per;
use App\Models\Produccion\paros;
use App\Models\Produccion\parosCarga;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ParosController extends Controller
{
    //
    public function index(Request $request){
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
        //manda array vacios
        $depa = [];
        $carga = [];

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

        //paros
        $paros = paros::get();

        return Inertia::render('Produccion/Paros', ['usuario' => $perf, 'depa' => $depa, 'cargas' => $carga, 'paros' => $paros]);
    }

    public function ParoCarga(Request $request) {
        //paros cargados
        $hoy = date('Y-m-d');
        $dia = date("Y-m-d",strtotime($hoy."- 1 days")).' 19:00:00';
        $mañana = date("Y-m-d",strtotime($hoy."+ 1 days")).' 07:00:00';

        $paros = parosCarga::where('departamento_id', '=', $request->departamento_id)
        ->whereBetween('fecha', [$dia, $mañana])
        ->orWhere(function($q) use ($dia, $request){
            $q->whereDate('fecha', '<=', $dia)
            ->where('departamento_id', '=', $request->departamento_id)
            ->where('estatus', '!=', 'Autorizado');
        })
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
        ->get(['id', 'fecha', 'iniFecha', 'orden', 'estatus', 'descri', 'finFecha', 'tiempo','paro_id', 'perfil_ini_id','perfil_fin_id', 'maq_pro_id', 'proceso_id', 'paros_carga_id', 'pla_acci', 'departamento_id']);

        return $paros;
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

        if ($request->paro_id == 13 || $request->paro_id == 14 || $request->paro_id == 16) {
            Validator::make($request->all(), [
                'orden' => ['required'],
                'descri' => ['required']
            ])->validate();
        }
        //return $request;
        $hoy = Carbon::now();
        foreach ($request->maq_pro_id as $maqui) {
            parosCarga::create([
                'fecha' => $hoy->toDateTimeString(),
                'iniFecha' => $hoy->toDateTimeString(),
                'paro_id' => $request->paro_id,
                'estatus' => $request->estatus,
                'perfil_ini_id' => $request->usu,
                'maq_pro_id' => $maqui,
                'proceso_id' => $request->proceso_id,
                'orden' => $request->orden,
                'VerInv' => $request->VerInv,
                'descri' => $request->descri,
                'departamento_id' => $request->departamento_id
            ]);
        }

        return redirect()->back()
            ->with('message', 'Post Created Successfully.');
    }

    public function update(Request $request)
    {
        //
        if ($request->paro_id == 13 || $request->paro_id == 14 || $request->paro_id == 16) {
            Validator::make($request->all(), [
                'pla_acci' => ['required']
            ])->validate();
        }
        //return $request->tiempo;
        $hoy = Carbon::now();
        if ($request->estatus == 'Autorizado') {
            $fecha = $request->finFecha;
            $tiempo = $request->tiempo;
        }else{
            $fecha = empty($request->finFecha) ? $request->finFecha : $hoy->toDateTimeString();
            $tiempo = empty($request->tiempo) ? $request->tiempo : $hoy->diffInMinutes($request->fecha);
            //return $request;
        }

        if ($request->has('id')) {
            parosCarga::find($request->input('id'))->update([
                'pla_acci' => $request->pla_acci,
                'perfil_fin_id' => $request->usu,
                'finFecha' => $fecha,
                'estatus' => $request->estatus,
                'tiempo' => $tiempo
            ]);
        }

        return redirect()->back()
            ->with('message', 'Post Created Successfully.');
    }

    public function destroy(Request $request)
    {
        if (isset($request->paros_carga_id)) {
            //return 'si entro '.$request->paros_carga_id;
            parosCarga::where('id', '=', $request->paros_carga_id)->delete();
        }else {
            parosCarga::find($request->input('id'))->delete();
        }
        return redirect()->back()
                ->with('message', 'Post Updated Successfully.');

    }
}
