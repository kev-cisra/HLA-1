<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\obje_cordi;
use App\Models\Produccion\AbaEntregas;
use App\Models\Produccion\Abastos\admi_abas;
use App\Models\Produccion\carga;
use App\Models\Produccion\catalogos\materiales;
use App\Models\Produccion\dep_mat;
use App\Models\Produccion\ObjetivoPuntas;
use App\Models\Produccion\ParoObje;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ObjeCordiController extends Controller
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
    public function index()
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

        return Inertia::render('Produccion/ObjeCordi', ['usuario' => $perf, 'depa' => $depa]);
    }

    public function storeProObje(Request $request){

        Validator::make($request->all(), [
            'equipo_id' => ['required'],
            'dep_perf_id' => ['required'],
            'turno_id' => ['required']
        ])->validate();

        foreach ($request->paquet as $value) {
            if (!empty($value['paqObjetivo'])) {
                $cosu = obje_cordi::where('id', '=', $value['paqObjetivo'])->first();

                $par = admi_abas::where('id', '=', $value['partida'])->first();
                $parnom  = $par->partida.$value['p_nom'];

                $clave = isset($cosu->clave_id) ? $cosu->clave_id : $value['clave_id'];
                $calcu = isset($value["calcuObje2"]) ? $value["calcuObje2"] : $value["calcuObje"];

                $carga = carga::create([
                    'fecha' => $request->fecha,
                    'semana' => $request->semana,
                    'per_carga' => $request->per_carga,
                    'proceso_id' => $cosu->proceso_id,
                    'dep_perf_id' => $request->dep_perf_id,
                    'maq_pro_id' => $cosu->maq_pro_id,
                    'partida' => $parnom,
                    'partida_id' => $value['partida'],
                    'valor' => $value['valor'],
                    'norma' => $cosu->norma,
                    'equipo_id' => $request->equipo_id,
                    'clave_id' => $clave,
                    'turno_id' => $request->turno_id,
                    'departamento_id' => $request->departamento_id,
                    'VerInv' => $calcu
                ]);

                foreach ($value['paroObje'] as $po) {
                    ParoObje::create([
                        'horas' => $po['horas'],
                        'paro_id' => $po['paro'],
                        'carga_id' => $carga->id
                    ]);
                }
                //return $value['paroObje'];


                if($request->departamento_id == 7){
                    ObjetivoPuntas::create([
                        'horas' => $value["calcuPunta"],
                        'valorPu' => $value['valorP'],
                        'carga_id' => $carga->id
                    ]);
                }
            }
        }
        return $request;

    }

    public function claTitu(Request $request){
        $titulo = dep_mat::join('materiales', 'materiales.id', '=', 'dep_mats.material_id')
            ->join('claves', 'claves.dep_mat_id', '=', 'dep_mats.id')
            ->where('dep_mats.departamento_id', '=', $request->departamento_id)
            ->where('dep_mats.id', '=', $request->norma)
            ->selectRaw('claves.calibre')
            ->groupBy('calibre')
            ->get();
        return $titulo;
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
        //return $request;
        Validator::make($request->all(), [
            'proceso_id' => ['required'],
            'maq_pro_id' => ['required'],
            'norma' => ['required'],
            'departamento_id' => ['required'],
            'pro_hora' => ['required'],
            'tip_maqui' => ['required']
        ])->validate();

        foreach ($request->maq_pro_id as $mq) {
            obje_cordi::create([
                'tiempo' => '60',
                'eficiencia' => "100",
                'tipo_maqui' => $request->tip_maqui,
                'husos' => $request->husos,
                'velocidad' => $request->velocidad,
                'titulo' => $request->titulo,
                'constante' => $request->constante,
                'cabos' => $request->cabos,
                'proceso_id' => $request->proceso_id,
                'maq_pro_id' => $mq,
                'clave_id' => $request->clave_id,
                'norma' => $request->norma,
                'departamento_id' => $request->departamento_id,
                'pro_hora' => $request->pro_hora
            ]);
        }


        return redirect()->back()
            ->with('message', 'Post Created Successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\obje_cordi  $obje_cordi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, obje_cordi $obje_cordi)
    {
        //return $request;

        Validator::make($request->all(), [
            'proceso_id' => ['required'],
            'maq_pro_id' => ['required'],
            'norma' => ['required'],
            'departamento_id' => ['required'],
            'pro_hora' => ['required']
        ])->validate();

        obje_cordi::find($request->input('id'))
        ->update([
            'tipo_maqui' => $request->tip_maqui,
            'husos' => $request->husos,
            'velocidad' => $request->velocidad,
            'titulo' => $request->titulo,
            'constante' => $request->constante,
            'cabos' => $request->cabos,
            'proceso_id' => $request->proceso_id,
            'maq_pro_id' => $request->maq_pro_id,
            'clave_id' => $request->clave_id,
            'norma' => $request->norma,
            'pro_hora' => $request->pro_hora
        ]);

        return redirect()->back()
            ->with('message', 'Post Created Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\obje_cordi  $obje_cordi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        if ($request->has('id')) {
            obje_cordi::find($request->input('id'))->delete();
            return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
        }
    }
}
