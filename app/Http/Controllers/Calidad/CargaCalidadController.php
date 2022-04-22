<?php

namespace App\Http\Controllers\Calidad;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Produccion\General\GeneralController;
use App\Models\Calidad\Carga\CargProcMeFibra;
use App\Models\Calidad\Catalogo\CataMediFibras;
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

        $catProce = $this->gene->ConCaliProce();

        return Inertia::render('Calidad/CargaCali', ['usuario' => $User, 'catproce' => $catProce]);
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
                    $cmf -> select('id', 'estatus', 'frecuencia', 'ml', 'sfc', 'ani_cal', 'algod_cal', 'composi', 'proce_calidad_id', 'cata_medi_fibra_id', 'observacion', 'car_me_fi_perfil_id', 'created_at')
                    ->orderBy('id', 'desc');
                },
                'perfil_proc' => function($per){
                    $per -> select('id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat');
                },
                'carg_mefibra.cataMediFibra' => function($cam){
                    $cam -> select('id', 'min_ml', 'max_ml', 'min_sfc', 'max_sfc', 'min_anillo', 'max_anillo', 'min_algodon', 'max_algodon');
                },
                'carg_mefibra.perfil_me_fi' => function($per){
                    $per -> select('id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat');
                }
            ])
            ->get();
        }else {
            $pr = ProceCalidad::where('proceso_id', '=', $request->proceso)
            ->where('partida', 'LIKE', '%'.$request->busca.'%')
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
                    $cmf -> select('id', 'estatus', 'frecuencia', 'ml', 'sfc', 'ani_cal', 'algod_cal', 'composi', 'proce_calidad_id', 'cata_medi_fibra_id', 'observacion', 'car_me_fi_perfil_id', 'created_at')
                    ->orderBy('id', 'desc');
                },
                'perfil_proc' => function($per){
                    $per -> select('id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat');
                },
                'carg_mefibra.cataMediFibra' => function($cam){
                    $cam -> select('id', 'min_ml', 'max_ml', 'min_sfc', 'max_sfc', 'min_anillo', 'max_anillo', 'min_algodon', 'max_algodon');
                },
                'carg_mefibra.perfil_me_fi' => function($per){
                    $per -> select('id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat');
                }
            ])
            ->get();
            /* $pr = ProceCalidad::join('maquinas', 'maquinas.id', '=', 'proce_calidads.maquina_id')
            ->join('claves', 'claves.id', '=', 'proce_calidads.clave_id')
            ->join('marcas_maquinas', 'marcas_maquinas.maquinas_id', '=', 'maquinas.id')
            ->join('carg_proc_me_fibras', 'carg_proc_me_fibras.proce_calidad_id', '=', 'proce_calidads.id')
            //->join('perfiles_usuarios', 'perfiles_usuarios.id', '=', 'carg_proc_me_fibras.car_me_fi_perfil_id')
            ->join('perfiles_usuarios', 'perfiles_usuarios.id', '=', 'proce_calidads.proc_perfil_id')
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
                'perfil_proc' => function($per){
                    $per -> select('id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat');
                },
                'carg_mefibra' => function($cmf){
                    $cmf -> select('id', 'estatus', 'frecuencia', 'ml', 'sfc', 'ani_cal', 'algod_cal', 'composi', 'proce_calidad_id', 'cata_medi_fibra_id', 'observacion', 'car_me_fi_perfil_id', 'created_at')
                    ->orderBy('id', 'desc');
                },
                'carg_mefibra.cataMediFibra' => function($cam){
                    $cam -> select('id', 'min_ml', 'max_ml', 'min_sfc', 'max_sfc', 'min_anillo', 'max_anillo', 'min_algodon', 'max_algodon');
                },
                'carg_mefibra.perfil_me_fi' => function($per){
                    $per -> select('id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat');
                }
            ])
            ->get(); */
        }
        return $pr;
    }

    public function saveMeFib(Request $request){
        Validator::make($request->all(), [
            'frecuencia' => ['required'],
            'ml' => ['required', 'numeric', 'min:0'],
            'sfc' => ['required', 'numeric', 'min:0', 'max:1'],
            'calculo_anillo' => ['numeric', 'min:0', 'max:1'],
            'calculo_algodon' => ['numeric', 'min:0', 'max:1']
        ])->validate();


        $cmf = CataMediFibras::where('clave_id', '=', $request->clave_id)
        ->first();

        $cata = !empty($cmf->id) ? $cmf->id : null;

        CargProcMeFibra::create([
            'frecuencia' => $request->frecuencia,
            'ml' => $request->ml,
            'sfc' => $request->sfc,
            'ani_cal' => $request->calculo_anillo,
            'algod_cal' => $request->calculo_algodon,
            'composi' => $request->composicion,
            'proce_calidad_id' => $request->proce_calidad_id,
            'cata_medi_fibra_id' => $cata,
            'car_me_fi_perfil_id' => $request->user,
            'observacion' => $request->observaciones
        ]);
        return $request->frecuencia;
    }
}
