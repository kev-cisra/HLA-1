<?php

namespace App\Http\Controllers\Produccion\General;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\Maquinas;
use App\Models\Produccion\catalogos\procesos;
use App\Models\Produccion\dep_mat;
use App\Models\Produccion\parosCarga;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    //
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
        }
        return $procesos;
    }

    public function ConMate(Request $request) {
        //materiales
        $mate = dep_mat::where('departamento_id', '=', $request->departamento_id)
        ->with([
            'materiales' => function($mat){
                $mat->select('id','idmat', 'nommat');
            },
            'claves' => function($cla){
                $cla -> select('id', 'CVE_ART', 'DESCR', 'UNI_MED', 'dep_mat_id');
            }
        ])
        ->get();
        return $mate;
    }
}
