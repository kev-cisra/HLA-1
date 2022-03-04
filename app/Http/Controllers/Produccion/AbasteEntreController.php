<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Produccion\carga;
use App\Models\Produccion\catalogos\procesos;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

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

        $depaTo = Departamentos::where('departamento_id', '=', $iddeppro->id)
            ->with('sub_Departamentos')
            ->get(['id', 'IdUser', 'Nombre', 'departamento_id']);

        return Inertia::render('Produccion/AbaEntre', ['usuario' => $perf, 'depa' => $depa, 'depaT' => $depaTo]);
    }

    public function Carga(Request $request){
        $pro = procesos::where('departamento_id', '=', $request->departamento_id)
        ->where('tipo_carga', '=', 'entre')
        ->with('sub__proceso')
        ->get();

        /* $car = carga::where('departamento_id', '=', $request->departamento_id)
        ->join('procesos', 'procesos.id', '=', 'cargas.proceso_id')
        ->where('procesos.tipo_carga', '=', 'entre')
        //->with('sub__proceso')
        ->get(); */
        return $pro;
    }
}
