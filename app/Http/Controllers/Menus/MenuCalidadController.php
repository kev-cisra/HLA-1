<?php

namespace App\Http\Controllers\Menus;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Produccion\General\GeneralController;
use App\Models\Calidad\Catalogo\CataProceCalidad;
use App\Models\Calidad\ProceCalidad;
use App\Models\Produccion\catalogos\claves;
use App\Models\Produccion\maq_pro;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MenuCalidadController extends Controller
{
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

        $calidad = $this->gene->ConAbast();

        $catProce = CataProceCalidad::get();

        $maquinas = maq_pro::join('procesos', 'procesos.id', '=', 'maq_pros.proceso_id')
        ->join('maquinas', 'maquinas.id', '=', 'maq_pros.maquina_id')
        ->join('marcas_maquinas', 'maquinas.id', '=', 'marcas_maquinas.maquinas_id')
        ->where('procesos.tipo', '=', '2')
        ->selectRaw('maq_pros.id AS mp_id, maquinas.id, CONCAT( maquinas.Nombre, " ", marcas_maquinas.Nombre) AS text, maquinas.departamento_id')
        ->get();

        return Inertia::render('Menus/Calidad', ['usuario' => $perf, 'abaentre' => $calidad, 'maquinas' => $maquinas, 'catproce' => $catProce]);
    }

    public function store(Request $request){
        foreach ($request->maquinas as $mq) {
            foreach ($request->procesos as $pr) {
                foreach ($request->clave as $cl) {
                    $cuenta = ProceCalidad::where('clave_id', '=', $cl)
                    ->where('partida_id', '=', $request->id)
                    ->where('maquina_id', '=', $mq)
                    ->where('proceso_id', '=', $pr)
                    ->count();

                    if ($cuenta == 0) {
                        $cla = claves::find($cl);

                        ProceCalidad::create([
                            'proceso_id' => $pr,
                            'partida' => $request->partida,
                            'partida_id' => $request->id,
                            'maquina_id' => $mq,
                            'clave_id' => $cl,
                            'dep_mat_id' => $cla->dep_mat_id,
                            'departamento_id' => $request->departamento_id
                        ]);
                    }
                }
            }
        }
        return $request;
    }

    public function ConProCali(Request $request){
        $pro = ProceCalidad::where('partida_id', '=', $request->id)
        ->with([
            'clave',
            'dep_mat',
            'dep_mat.materiales',
            'maquina',
            'maquina.marca',
            'cat_proce_cali',
            'departaemnto'
        ])
        ->get();

        return $pro;
    }
}
