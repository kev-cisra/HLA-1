<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Produccion\dep_per;
use App\Models\Produccion\equipos;
use App\Models\Produccion\turnos;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class TurnosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Produccion.turnos.index|admin.index']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        /***************** Información de la persona  *****************************/
        //Muestra el id de la persona que inicio sesion
        $usuario = Auth::id();
        //muestra la información del usuario que inicio sesion
        $perf = PerfilesUsuarios::where('user_id','=',$usuario)
            ->with('dep_pers')
            ->first();

        $turnos = [];
        $equipos = [];
        $personal =[];

         /*************** Información para mostrar áreas *************************/
         if(count($perf->dep_pers) != 0){
            //consulta las areas que le pertenecen al usuario
            $depa = dep_per::where('perfiles_usuarios_id','=',$perf->id)
                ->with([
                'departamentos' => function($dep){
                        $dep->select('id', 'Nombre', 'departamento_id');
                    }])
                ->get(['id','perfiles_usuarios_id', 'departamento_id']);
            /************************* Información de maquinas para coordinador, encargado y lider*************************/
            //se consulta el primer departamento que tiene la persona asignada
            $prime = dep_per::where('perfiles_usuarios_id','=',$perf->id)
                ->with([
                'departamentos' => function($dep){
                        $dep->select('id');
                    }])
                ->first(['id', 'departamento_id']);
            $turnos = turnos::where('departamento_id', '=', $prime->departamentos->id)
                ->with([
                    'equipos' => function($equ){
                        $equ->select('id','nombre','turno_id','departamento_id');
                    },
                    'departamento' => function($depa){
                        $depa->select('id', 'Nombre');
                    },
                    'equipos.dep_pers.perfiles' => function($perfi){
                        $perfi->select('id', 'Nombre', 'ApPat', 'ApMat');
                    }
                ])
                ->get();
            $personal = dep_per::where('departamento_id', '=', $prime->departamentos->id)
                ->where(function($query){
                    $query->where('ope_puesto', '=', 'enc')
                        ->orWhere('ope_puesto', '=','lid')
                        ->orWhere('ope_puesto', '=','ope');
                    }
                )
                ->with([
                    'perfiles' => function($perfi){
                        $perfi->select('id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat');
                    }
                ])
                ->get();
            $equipos = equipos::where('departamento_id', '=', $prime->departamentos->id)
                ->with([
                    'turnos' => function($tur){
                        $tur->select('id', 'nomtur');
                    },
                    'dep_pers.perfiles' => function($perfi){
                        $perfi->select('id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat');
                    }
                ])
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
            $turnos = turnos::where('departamento_id', '=', $request->busca)
                ->with([
                    'equipos' => function($equ){
                        $equ->select('id','nombre','turno_id', 'departamento_id');
                    },
                    'departamento' => function($depa){
                        $depa->select('id', 'Nombre');
                    },
                    'equipos.dep_pers.perfiles' => function($perfi){
                        $perfi->select('id', 'Nombre', 'ApPat', 'ApMat');
                    }
                ])
                ->get();

            $personal = dep_per::where('departamento_id', '=', $request->busca)
                    ->where(function($query){
                        $query->where('ope_puesto', '=', 'enc')
                        ->orWhere('ope_puesto', '=','lid')
                        ->orWhere('ope_puesto', '=','ope');
                    })
                    ->with([
                        'perfiles' => function($perfi){
                            $perfi->select('id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat');
                        }
                    ])
                    ->get();


            $equipos = equipos::where('departamento_id', '=', $request->busca)
                    ->with([
                        'turnos' => function($tur){
                            $tur->select('id', 'nomtur');
                        },
                        'dep_pers.perfiles' => function($perfi){
                            $perfi->select('id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat');
                        }
                    ])
                    ->get();
        }

        return Inertia::render('Produccion/Turnos', ['usuario' => $perf,'depa' => $depa,'turno' => $turnos,'equipos' => $equipos, 'personal' => $personal]);

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
            'nomtur' => ['required'],
            'departamento_id' => ['required'],
            'LVIni' => ['required'],
            'LVFin' => ['required'],
            'SDIni' => ['required'],
            'SDFin' => ['required'],
            'cargaExt' => ['required'],
        ])->validate();

        //consulta si ya esta registrado ese usuario
        $query = turnos::where("nomtur", "=", $request->nomtur)
            ->withTrashed ()
            ->where('departamento_id', '=', $request->departamento_id)
            ->first();
        if(!empty($query)){
            //revisa si el soft delete exite para restaurarlo
            if(!empty($query->deleted_at))
            {
                $query->restore();
            }//revisa si ya existe el usuario y el delete es nulo para mandar un aviso
            else{
                Validator::make($request->all(),[
                    'nomtur' => ['unique:turnos']
                ])->validate();
            }
        }else{
            turnos::create($request->all());
        }

        return redirect()->back()
            ->with('message', 'Post Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produccion\turnos  $turnos
     * @return \Illuminate\Http\Response
     */
    public function show(turnos $turnos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produccion\turnos  $turnos
     * @return \Illuminate\Http\Response
     */
    public function edit(turnos $turnos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produccion\turnos  $turnos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, turnos $turnos)
    {
        //
        Validator::make($request->all(), [
            'nomtur' => ['required'],
            'departamento_id' => ['required'],
            'LVIni' => ['required'],
            'LVFin' => ['required'],
            'SDIni' => ['required'],
            'SDFin' => ['required'],
            'cargaExt' => ['required'],
        ])->validate();

        if ($request->has('id')) {
            turnos::find($request->input('id'))->update([
                'nomtur' => $request->nomtur,
                'departamento_id' => $request->departamento_id,
                'LVIni' => $request->LVIni,
                'LVFin' => $request->LVFin,
                'SDIni' => $request->SDIni,
                'SDFin' => $request->SDFin,
                'VerInv' => $request->VerInv,
                'cargaExt' => $request->cargaExt,
            ]);
            return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
        }

        return redirect()->back()
            ->with('message', 'Post Created Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produccion\turnos  $turnos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        if ($request->has('id')) {
            turnos::find($request->input('id'))->delete();
            return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
        }
    }
}
