<?php

namespace App\Http\Controllers\Produccion\General;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\Maquinas;
use App\Models\Produccion\AbaEntregas;
use App\Models\Produccion\Abastos\admi_abas;
use App\Models\Produccion\catalogos\procesos;
use App\Models\Produccion\dep_mat;
use App\Models\Produccion\dep_per;
use App\Models\Produccion\parosCarga;
use App\Models\Produccion\turnos;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\User;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    //Consulta las maquinas
    public function ConMaqui(Request $request) {
        //Maquinas
        $Maqui = Maquinas::where('departamento_id', '=', $request->departamento_id)
        ->with([
            'marca' => function($mar) {
                $mar -> select('id', 'Nombre', 'maquinas_id');
            }
        ])
        ->get(['id', 'Nombre', 'departamento_id']);
        return $Maqui;
    }

    //Consulta los procesos
    public function ConProdu(Request $request) {
        //procesos
        if ($request->modulo == "repoPro") {
            $procesos = procesos::where('departamento_id', '=', $request->departamento_id)
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
        }elseif ($request->modulo == "Paros") {
            $procesos = procesos::where('departamento_id', '=', $request->departamento_id)
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
        }elseif ($request->modulo == "carPro") {
            //muestran los departamentos
            $procesos = procesos::where('departamento_id', '=', $request->departamento_id)
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
        }
        return $procesos;
    }

    //Consulta los materiales
    public function ConMate(Request $request) {
        //materiales
        $mate = dep_mat::where('departamento_id', '=', $request->departamento_id)
        ->with([
            'materiales' => function($mat){
                $mat->select('id','idmat', 'nommat');
            },
            'claves' => function($cla){
                $cla -> select('id', 'CVE_ART', 'DESCR', 'UNI_MED', 'categoria', 'torsion', 'color', 'calibre', 'dep_mat_id');
            }
        ])
        ->get();
        return $mate;
    }

    //consulta las empresas que existen
    public function ConEmpre() {
        $user = User::select('Empresa')->distinct()->get();
        return $user;
    }

    //Consulta personal y equipos
    public function ConPerso(Request $request){
        //muestra el personal del departamento
        $personal = dep_per::where('departamento_id', '=', $request->departamento_id)
        ->with([
            'perfiles' => function($perfi){
                $perfi->select('id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat');
            },
            'equipo' => function($eq){
                $eq -> select('id', 'nombre', 'turno_id');
            },
            'equipo.turnos' => function($tur){
                $tur -> select('id', 'nomtur');
            }
        ])
        ->get(['id', 'perfiles_usuarios_id', 'ope_puesto', 'departamento_id', 'equipo_id']);
        return $personal;
    }

    //Consulta los turnos
    public function ConTurno(Request $request){
        //Turnos
        $turnos = turnos::where('departamento_id', '=', $request->departamento_id)
        ->with([
            'equipos' => function ($eq) {
                $eq -> select('id', 'nombre', 'turno_id');
            }
        ])
        ->get(['id', 'nomtur', 'departamento_id']);
        return $turnos;
    }

    //Consulta departamentos
    public function ConDepa(Request $request){
        $depa = Departamentos::whereNotNull('departamento_id')
        ->get();
        return $depa;
    }

    //Consulta partida
    public function ConParti(Request $request){
        $par = admi_abas::where('departamento_id', '=', $request->departamento_id)
        ->where('estatus', '=', '1')
        ->with([
            'aba_entregas' => function($ae){
                $ae->select('id', 'folio', 'banco', 'esta_inicio', 'esta_final', 'total', 'perfi_abas', 'perfi_entrega', 'soli_aba_id', 'admi_abas_id');
            },
            'proc_final_aba' => function($pfa){
                $pfa->where('estatus', '=', 1)
                ->select('id', 'estatus', 'norma_id', 'clave_id', 'admi_abas_id');
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


        /* AbaEntregas::where('depa_entrega', '=', $request->departamento_id)
        ->with('clave')
        ->where('esta_final', '=', 'Activo')
        ->get(); */

        return $par;
    }

    //Consulta de abastos general
    public function ConAbast(){
        $aba = admi_abas::where('estatus', '=', 1)
            ->orderBy('id', 'desc')
            ->with([
                'aba_entregas' => function($ae){
                    $ae->select('id', 'folio', 'banco', 'esta_inicio', 'esta_final', 'total', 'perfi_abas', 'perfi_entrega', 'soli_aba_id', 'admi_abas_id');
                },
                'proc_final_aba' => function($pfa){
                    $pfa->where('estatus', '=', 1)
                    ->select('id', 'estatus', 'norma_id', 'clave_id', 'admi_abas_id');
                },
                'proc_final_aba.norma' => function($pfan){
                    $pfan->select('id', 'departamento_id', 'material_id');
                },
                'proc_final_aba.norma.materiales' => function($pfnm){
                    $pfnm->select('id', 'idmat', 'nommat');
                },
                'proc_final_aba.clave' => function($pfac){
                    $pfac->select('id', 'CVE_ART', 'DESCR', 'UNI_MED');
                },
                'departamento' => function($dep){
                    $dep->select('id', 'Nombre', 'departamento_id');
                }
            ])
            ->get(['id', 'partida', 'folio2', 'total', 'estatus', 'perfil_id', 'departamento_id']);

        return $aba;
    }
}
