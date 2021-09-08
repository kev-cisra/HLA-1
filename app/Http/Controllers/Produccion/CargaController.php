<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Produccion\carga;
use App\Models\Produccion\catalogos\procesos;
use App\Models\Produccion\dep_mat;
use App\Models\Produccion\dep_per;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

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
        $carga = [];
        $procesos = [];
        $personal = [];
        $mate = [];
        $carga = [];

        if (count($perf->dep_pers) != 0) {
            //muestran los departamentos
            $depa = $perf->dep_pers;
            //muestra de procesos dependiendo del puesto
            $procesos = procesos::where('departamento_id', '=', $perf->Departamento_id)
                ->where('tipo','!=', '3')
                ->with([
                    'maq_pros' => function($mp){
                        $mp->select('id', 'proceso_id', 'maquina_id')
                        ->with('maquinas');
                    }
                ])
                ->get();
            //muestra el personal del departamento
            $personal = dep_per::where('departamento_id', '=', $perf->Departamento_id)
                ->with([
                    'perfiles' => function($perfi){
                        $perfi->select('id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat');
                    },
                    'equipo' => function($eq){
                        $eq -> select('id', 'nombre', 'turno_id');
                    }
                ])
                ->get(['id', 'perfiles_usuarios_id', 'ope_puesto', 'departamento_id', 'equipo_id']);
            //materiales
            $mate = dep_mat::where('departamento_id', '=', $perf->Departamento_id)
                ->with([
                    'materiales' => function($mat){
                        $mat->select('id','idmat', 'nommat');
                    },
                    'claves' => function($cla){
                        $cla -> select('id', 'CVE_ART', 'DESCR', 'UNI_MED', 'dep_mat_id');
                    }
                ])
                ->get();
            //carga
            $carga = dep_per::select(
                'cargas.id AS id',
                'perfiles_usuarios.Nombre AS Pnom',
                'perfiles_usuarios.ApPat AS Pap',
                'perfiles_usuarios.ApMat AS Pam',
                'dep_pers.ope_puesto AS DPpue',
                'departamentos.Nombre AS Dnom',
                'equipos.nombre AS Enom',
                'turnos.nomtur AS Tnom',
                'cargas.fecha AS Cfec',
                'cargas.semana AS Csem',
                'cargas.valor AS Cval',
                'cargas.partida AS Cpar',
                'cargas.notaPen AS Cnp',
                'materiales.idmat AS Midm',
                'materiales.nommat AS Mnom',
                'maquinas.nombre AS MAnom',
                'claves.CVE_ART AS CLcla',
                'claves.DESCR AS CLdes'
            )
            ->where('dep_pers.departamento_id', '=', $perf->Departamento_id)
            ->join('perfiles_usuarios', 'perfiles_usuarios.id', '=', 'dep_pers.perfiles_usuarios_id' )
            ->join('departamentos', 'departamentos.id', '=', 'dep_pers.departamento_id')
            ->join('cargas', 'cargas.dep_perf_id', '=', 'dep_pers.id')
            ->leftJoin('equipos', 'equipos.id', '=', 'cargas.equipo_id')
            ->leftJoin('turnos', 'turnos.id', '=', 'cargas.turno_id')
            ->leftJoin('dep_mats', 'dep_mats.id', '=', 'cargas.norma')
            ->leftJoin('materiales', 'materiales.id', '=', 'dep_mats.material_id')
            ->leftJoin('claves', 'claves.id', '=', 'cargas.clave_id')
            ->leftJoin('maq_pros', 'maq_pros.id', '=', 'cargas.maq_pro_id')
            ->leftJoin('maquinas', 'maquinas.id', '=', 'maq_pros.maquina_id')
            ->leftJoin('procesos', 'procesos.id', '=', 'maq_pros.proceso_id')
            ->get();
        }else{
            //consulta el id de la area produccion
            $iddeppro = Departamentos::where('Nombre', '=', 'OPERACIONES')
                ->first();
            //muestra las areas y sub areas de produccion
            $depa = Departamentos::where('departamento_id', '=', $iddeppro->id)
                ->with('sub_Departamentos')
                ->get(['id', 'IdUser', 'Nombre', 'departamento_id']);
        }



        /**************************** consulta si existe la busqueda  ****************************************************/
        if (!empty($request->busca)) {
            //muestran los departamentos
            $procesos = procesos::where('departamento_id', '=', $request->busca)
                ->where('tipo', '!=', '3')
                ->with([
                    'maq_pros' => function($mp){
                        $mp->select('id', 'proceso_id', 'maquina_id')
                        ->with('maquinas');
                    }
                ])
                ->get();
            //muestra el personal del departamento
            $personal = dep_per::where('departamento_id', '=', $request->busca)
                ->with([
                    'perfiles' => function($perfi){
                        $perfi->select('id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat');
                    },
                    'equipo' => function($eq){
                        $eq -> select('id', 'nombre', 'turno_id');
                    }
                ])
                ->get(['id', 'perfiles_usuarios_id', 'ope_puesto', 'departamento_id', 'equipo_id']);
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
            //carga
            $carga = dep_per::select(
                'cargas.id AS id',
                'perfiles_usuarios.Nombre AS Pnom',
                'perfiles_usuarios.ApPat AS Pap',
                'perfiles_usuarios.ApMat AS Pam',
                'dep_pers.ope_puesto AS DPpue',
                'departamentos.Nombre AS Dnom',
                'equipos.nombre AS Enom',
                'turnos.nomtur AS Tnom',
                'cargas.fecha AS Cfec',
                'cargas.semana AS Csem',
                'cargas.valor AS Cval',
                'cargas.partida AS Cpar',
                'cargas.notaPen AS Cnp',
                'materiales.idmat AS Midm',
                'materiales.nommat AS Mnom',
                'maquinas.nombre AS MAnom',
                'claves.CVE_ART AS CLcla',
                'claves.DESCR AS CLdes'
            )
            ->where('dep_pers.departamento_id', '=', $request->busca)
            ->join('perfiles_usuarios', 'perfiles_usuarios.id', '=', 'dep_pers.perfiles_usuarios_id' )
            ->join('departamentos', 'departamentos.id', '=', 'dep_pers.departamento_id')
            ->join('cargas', 'cargas.dep_perf_id', '=', 'dep_pers.id')
            ->leftJoin('equipos', 'equipos.id', '=', 'cargas.equipo_id')
            ->leftJoin('turnos', 'turnos.id', '=', 'cargas.turno_id')
            ->leftJoin('dep_mats', 'dep_mats.id', '=', 'cargas.norma')
            ->leftJoin('materiales', 'materiales.id', '=', 'dep_mats.material_id')
            ->leftJoin('claves', 'claves.id', '=', 'cargas.clave_id')
            ->leftJoin('maq_pros', 'maq_pros.id', '=', 'cargas.maq_pro_id')
            ->leftJoin('maquinas', 'maquinas.id', '=', 'maq_pros.maquina_id')
            ->leftJoin('procesos', 'procesos.id', '=', 'maq_pros.proceso_id')
            ->get();
        }


        return Inertia::render('Produccion/Carga', ['usuario' => $perf, 'depa' => $depa, 'cargas' => $carga, 'procesos' => $procesos, 'personal' => $personal, 'materiales' => $mate, 'cargas' => $carga]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        Validator::make($request->all(), [
            'proceso_id' => ['required'],
            'dep_perf_id' => ['required'],
            'valor' => ['required']
        ])->validate();

        carga::create($request->all());

        return redirect()->back()
            ->with('message', 'Post Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produccion\carga  $carga
     * @return \Illuminate\Http\Response
     */
    public function show(carga $carga)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produccion\carga  $carga
     * @return \Illuminate\Http\Response
     */
    public function edit(carga $carga)
    {
        //
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produccion\carga  $carga
     * @return \Illuminate\Http\Response
     */
    public function destroy(carga $carga)
    {
        //
    }
}
