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
use Carbon\Carbon;
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
        $mate = [];
        $procesos = [];
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

        //claves de los paros
        $claParo = paros::get();

         /**************************** consulta si existe la busqueda  ****************************************************/
        if (!empty($request->busca)) {

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

        return Inertia::render('Produccion/Reportes/RProduccion', ['usuario' => $perf, 'depa' => $depa, 'materiales' => $mate, 'procesos' => $procesos, 'claParo' => $claParo, 'maquinas' => $Maqui]);
    }

    public function ConProdu(Request $request){
        if (!empty($request->iniDia)) {
            $addDia = date("Y-m-d H:m:s" , strtotime($request->iniDia."+ 1 days"));
            $carga = carga::where('departamento_id', '=', $request->departamento_id);
        }
        return $request->iniDia.' '.$addDia;
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
