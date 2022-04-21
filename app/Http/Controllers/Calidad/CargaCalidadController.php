<?php

namespace App\Http\Controllers\Calidad;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Produccion\General\GeneralController;
use App\Models\Calidad\Carga\CargProcMeFibra;
use App\Models\Calidad\ProceCalidad;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CargaCalidadController extends Controller
{
    //
    protected $gene;

    public function __construct(GeneralController $gene)
    {
        $this->gene = $gene;
    }
    //
    public function index(){
        $User = Auth::user();
        //muestra la información del usuario que inicio sesion
        $perf = PerfilesUsuarios::where('user_id','=',$User)
            ->with([
                'dep_pers' => function($dp){
                    $dp -> select('id', 'perfiles_usuarios_id', 'ope_puesto', 'equipo_id', 'departamento_id');
                }
            ])
            ->first(['id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat', 'jefe_id', 'user_id', 'Puesto_id', 'Departamento_id', 'jefes_areas_id']);

        $catProce = $this->gene->ConCaliProce();

        return Inertia::render('Calidad/CargaCali', ['usuario' => $perf, 'catproce' => $catProce]);
    }

    public function ConLisProce(Request $request){
        if (empty($request->busca)) {
            $pr = ProceCalidad::where('proceso_id', '=', $request->proceso)
            ->with([
                'maquina' => function($ma){
                    $ma -> select('id', 'Nombre', 'Departamento', 'departamento_id');
                },
                'clave' => function($cl){
                    $cl -> select('id', 'CVE_ART', 'DESCR', 'UNI_MED');
                },
                'maquina.marca' => function($mar){
                    $mar -> select('id' ,'Nombre', 'maquinas_id');
                },
                'cat_proce_cali' => function($cpc){
                    $cpc -> select('id', 'nombre', 'ubicacion', 'aplicacion');
                },
                'carg_mefibra' => function($cmf){
                    $cmf -> select('id', 'estatus', 'frecuencia', 'ml', 'sfc', 'ani_cal', 'algod_cal', 'composi', 'proce_calidad_id', 'cata_medi_fibra_id', 'observacion', 'created_at')
                    ->orderBy('id', 'desc');
                }
            ])
            ->get();
        }else {
            $pr = ProceCalidad::join('maquinas', 'maquinas.id', '=', 'proce_calidads.maquina_id')
            ->join('claves', 'claves.id', '=', 'proce_calidads.clave_id')
            ->join('marcas_maquinas', 'marcas_maquinas.maquinas_id', '=', 'maquinas.id')
            ->where('proceso_id', '=', $request->proceso)
            ->whereRaw('CONCAT_WS(" ", proce_calidads.partida, maquinas.Nombre, marcas_maquinas.Nombre, claves.DESCR) LIKE "%'.$request->busca.'%"')
            ->with([
                'maquina' => function($ma){
                    $ma -> select('id', 'Nombre', 'Departamento', 'departamento_id');
                },
                'clave' => function($cl){
                    $cl -> select('id', 'CVE_ART', 'DESCR', 'UNI_MED');
                },
                'maquina.marca' => function($mar){
                    $mar -> select('id' ,'Nombre', 'maquinas_id');
                },
                'cat_proce_cali' => function($cpc){
                    $cpc -> select('id', 'nombre', 'ubicacion', 'aplicacion');
                },
                'carg_mefibra' => function($cmf){
                    $cmf -> select('id', 'estatus', 'frecuencia', 'ml', 'sfc', 'ani_cal', 'algod_cal', 'composi', 'proce_calidad_id', 'cata_medi_fibra_id', 'observacion', 'created_at')
                    ->orderBy('id', 'desc');
                }
            ])
            ->get();
        }
        return $pr;
    }

    public function saveMeFib(Request $request){
        Validator::make($request->all(), [
            'frecuencia' => ['required'],
            'ml' => ['required', 'numeric', 'min:0'],
            'sfc' => ['required', 'numeric', 'min:0'],
            'ani_cal' => ['numeric', 'min:0'],
            'algod_cal' => ['numeric', 'min:0']
        ])->validate();

        CargProcMeFibra::create([
            'frecuencia' => $request->frecuencia,
            'ml' => $request->ml,
            'sfc' => $request->sfc,
            'ani_cal' => $request->calculo_anillo,
            'algod_cal' => $request->calculo_algodon,
            'composi' => $request->composicion,
            'proce_calidad_id' => $request->proce_calidad_id,
            'cata_medi_fibra_id' => null,
            'observacion' => $request->observaciones
        ]);
        return $request->frecuencia;
    }
}
