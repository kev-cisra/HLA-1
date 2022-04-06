<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Produccion\Abastos\AbaEntregas;
use App\Models\Produccion\Abastos\admi_abas;
use App\Models\Produccion\Abastos\Proc_Fin_Abas;
use App\Models\Produccion\Abastos\ProcFinAbas;
use App\Models\Produccion\carga;
use App\Models\Produccion\catalogos\procesos;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Validation\Rule;

class AbasteEntreController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Produccion.reporpro.index|admin.index']);
    }

    //
    public function index(){
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
        $depaTo = [];

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

        $depaTo = Departamentos::where('departamento_id', '=', '2')
            ->with('sub_Departamentos')
            ->get(['id', 'IdUser', 'Nombre', 'departamento_id']);

        return Inertia::render('Produccion/AbaEntre', ['usuario' => $perf, 'depa' => $depa, 'depaT' => $depaTo]);
    }

    public function ConAbaEntre(Request $request){
        //return $request;
        if (empty($request->busca)) {
            # code...
            $aba = admi_abas::where('departamento_id', '=', $request->departamento_id)
            ->whereIn('estatus', [1,2,3])
            ->orderBy('id', 'desc')
            ->with([
                'aba_entregas' => function($ae){
                    $ae->select('id', 'folio', 'banco', 'esta_inicio', 'esta_final', 'total', 'perfi_abas', 'perfi_entrega', 'soli_aba_id', 'admi_abas_id');
                },
                'proc_final_aba' => function($pfa){
                    $pfa->select('id', 'estatus', 'norma_id', 'clave_id', 'admi_abas_id');
                },
                'proc_final_aba.norma' => function($pfan){
                    $pfan->select('id', 'departamento_id', 'material_id');
                },
                'proc_final_aba.norma.materiales' => function($pfnm){
                    $pfnm->select('id', 'idmat', 'nommat');
                },
                'proc_final_aba.clave' => function($pfac){
                    $pfac->select('id', 'CVE_ART', 'DESCR', 'UNI_MED');
                }
            ])
            ->get();
        }else{
            $aba = admi_abas::where('departamento_id', '=', $request->departamento_id)
            ->whereIn('estatus', [1,2,3])
            ->orderBy('id', 'desc')
            ->where('partida', 'like', '%'.$request->busca.'%')
            ->with([
                'aba_entregas' => function($ae){
                    $ae->select('id', 'folio', 'banco', 'esta_inicio', 'esta_final', 'total', 'perfi_abas', 'perfi_entrega', 'soli_aba_id', 'admi_abas_id');
                },
                'proc_final_aba' => function($pfa){
                    $pfa->select('id', 'estatus', 'norma_id', 'clave_id', 'admi_abas_id');
                },
                'proc_final_aba.norma' => function($pfan){
                    $pfan->select('id', 'departamento_id', 'material_id');
                },
                'proc_final_aba.norma.materiales' => function($pfnm){
                    $pfnm->select('id', 'idmat', 'nommat');
                },
                'proc_final_aba.clave' => function($pfac){
                    $pfac->select('id', 'CVE_ART', 'DESCR', 'UNI_MED');
                }
            ])
            ->get();
        }
        return $aba;
    }

    public function updeAbas(Request $request){
        Validator::make($request->all(), [
            'esta_final' => ['required'],
            'norma_id' => ['required'],
            'clave_id' => ['required'],
            'partida' => ['required']
        ])->validate();

        AbaEntregas::find($request->input('id'))
        ->update([
            'partida' => $request->partida,
            'esta_inicio' => 'Aceptado',
            'esta_final' => $request->esta_final,
            'norma_id' => $request->norma_id,
            'clave_id' => $request->clave_id
        ]);
    }

    public function Carga(Request $request){
        $pro = procesos::where('departamento_id', '=', $request->departamento_id)
        ->where('tipo', '=', "4")
        ->whereNotNull('proceso_id')
        ->selectRaw('id')
        ->get();
        /* procesos::where('departamento_id', '=', $request->departamento_id)
        ->where('tipo_carga', '=', 'entre')
        ->with([
            'sub_proceso' => function($sp) {
                $sp->select('id', 'nompro', 'proceso_id');
            }
        ])
        ->first(); */

        $car = carga::where('departamento_id', '=', $request->departamento_id)
        ->whereIn('proceso_id', [42])
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
        ->get();
        return $car;
    }

    public function entregaInsert(Request $request){
        Validator::make($request->all(), [
            'folio' => ['required'],
            'partida' => ['required'],
            'total' => ['required', 'numeric'],
            'departamento_id' => ['required']
        ])->validate();

        $fol2 = admi_abas::where('departamento_id', '=', $request->departamento_id)
            ->orderBy('id', 'desc')
            ->first();

        //crea el folio 2
        if(empty($fol2->folio2)){
            $folio2 = date('M/y').'-1';
            //echo '1';
        }else{
            $cam = explode("-", $fol2->folio2);
            $fec = explode("/", $cam[0]);
            //Verifica el año para reiniciar folio
            if ($fec[1] != date("y")) {
                $folio2 = date('M/y').'-1';
                //echo '2-1';
            }else{
                $sum = $cam[1]+1;
                $folio2 = date('M/y').'-'.$sum;
                //echo '2-2';
            }
        }

        //return $request;

        //Insert administrador abastos
        if(empty($request->abasExis)){
            //valida por departamento la partida
            $cuen = admi_abas::where('partida', '=', $request->partida)
            ->where('departamento_id', '=', $request->departamento_id)
            ->count();
            if ($cuen == 0) {
                $ad_aba = admi_abas::create([
                    'partida' => $request->partida,
                    'folio2' => $folio2,
                    'total' => $request->total,
                    'estatus' => '3',
                    'perfil_id' => $request->perfi_abas,
                    'departamento_id' => $request->departamento_id
                ]);
            }else {
                Validator::make($request->all(), [
                    'partida' => ['unique:admi_abas,partida']
                ])->validate();
                //return $request;
            }
        }else{
            $ad_aba = admi_abas::find($request->partida);
            admi_abas::find($request->partida)->update(['total' => $request->total+$ad_aba->total]);
        }

        //insert abastos entregas
        AbaEntregas::create([
            'folio' => $request->folio,
            'banco' => $request->banco,
            'total' => $request->total,
            'esta_inicio' => $request->esta_inicio,
            'esta_final' => $request->esta_final,
            'perfi_entrega' => $request->perfi_entrega,
            'admi_abas_id' => $ad_aba->id
        ]);

        //insert claves y normas
        foreach ($request->produ as $nc) {
            if (!empty($nc['clave'])) {
                ProcFinAbas::create([
                    'estatus' => 1,
                    'norma_id' => $nc['norma'],
                    'clave_id' => $nc['clave'],
                    'admi_abas_id' => $ad_aba->id
                ]);
            }
        }
    }

    public function ConAbaPro(Request $request){
        $ap = carga::join('procesos', 'procesos.id', '=', 'cargas.proceso_id')
        ->whereIn('procesos.tipo', ['1', '4', '5'])
        ->where('cargas.partida_id', '=', $request->id)
        ->selectRaw('cargas.proceso_id, cargas.maq_pro_id, cargas.clave_id, SUM(cargas.valor) AS valor')
        ->groupBy('proceso_id')
        ->groupBy('clave_id')
        ->groupBy('maq_pro_id')
        ->with([
            'proceso' => function($pr){
                $pr ->withTrashed()
                -> select('id', 'nompro', 'tipo', 'operacion', 'proceso_id');
            },
            'maq_pro' => function($mp){
                $mp ->withTrashed()
                ->select('id', 'proceso_id', 'maquina_id');
            },
            'maq_pro.maquinas' => function($ma){
                $ma ->withTrashed()
                -> select('id', 'Nombre');
            },
            'clave' => function($cla){
                $cla ->withTrashed()
                -> select('id', 'CVE_ART', 'DESCR', 'categoria', 'UNI_MED');
            },
        ])
        ->get();
        return $ap;
    }

    public function UpdeEstatus(Request $request){
        $ab = admi_abas::find($request->id)->update([
            'estatus' => $request->estatus
        ]);
        return 'listo';
    }

    public function ConAbaFin(Request $request){
        $aba = AbaEntregas::where('depa_entrega', '=', $request->departamento)
        ->whereBetween('created_at', [$request->fechaini, $request->fechafin])
        ->where('esta_final', '=', 'Fin')
        ->with([
            'norma' => function($no){
                $no->select('id', 'departamento_id', 'material_id');
            },
            'norma.materiales' => function($ma){
                $ma->select('id', 'idmat', 'nommat', 'estatus');
            },
            'clave' => function($cl){
                $cl->select('id', 'CVE_ART', 'DESCR');
            },
            'depa_entregas' => function($de){
                $de->select('id', 'Nombre', 'departamento_id');
            },
            'depa_recibe' => function($dr){
                $dr->select('id', 'Nombre', 'departamento_id');
            }
        ])
        ->get();
        return $aba;
    }

    public function EstatusParti(Request $request){
        //return $request;
        admi_abas::find($request->id)->update([
            'estatus' => $request->estatus
        ]);
        return 'listo';
    }

    public function EstatusProcFin(Request $request){
        ProcFinAbas::find($request->id)->update([
            'estatus' => $request->estatus
        ]);
        return 'ok';
    }

    public function UpdaPart(Request $request){
        $cuen = admi_abas::where('partida', '=', $request->partida)
            ->where('departamento_id', '=', $request->departamento_id)
            ->count();

        if ($cuen == 0) {
            admi_abas::find($request->id)->update(['partida' => $request->partida]);
            return 'listo';
        }
        Validator::make($request->all(), [
            'partida' => ['unique:admi_abas,partida']
        ])->validate();

    }
}
