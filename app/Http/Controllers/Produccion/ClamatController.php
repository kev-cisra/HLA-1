<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Produccion\catalogos\claves;
use App\Models\Produccion\catalogos\materiales;
use App\Models\Produccion\dep_mat;
use App\Models\Produccion\dep_per;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ClamatController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Produccion.clamat.index|admin.index']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Muestra el id de la persona que inicio sesion
        $usuario = Auth::id();
        //muestra la información del usuario que inicio sesion
        $perf = PerfilesUsuarios::where('user_id','=',$usuario)
            ->with('dep_pers')
            ->first();

        $depa = null;
        $clamat = null;

        /*************** Información para mostrar áreas *************************/
        if(count($perf->dep_pers) != 0){
            //consulta las areas que le pertenecen al usuario
            $depa = dep_per::where('perfiles_usuarios_id','=',$perf->id)
                ->with([
                'departamentos' => function($dep){
                        $dep->select('id', 'Nombre', 'departamento_id');
                    }])
                ->get(['id','perfiles_usuarios_id', 'departamento_id']);
            /************************* Información de maquinas para coordinador, encargado y lider *************************/
            //se consulta el primer departamento que tiene la persona asignada
            $prime = dep_per::where('perfiles_usuarios_id','=',$perf->id)
                ->with([
                    'departamentos' => function($dep){
                        $dep->select('id');
                    }])
                ->first(['id', 'departamento_id']);
            //se consultan las maquinas que estan en ese departamento
            $clamat = dep_mat::where('departamento_id', '=', $prime->departamentos->id)
                ->with([
                    'materiales' => function($ma){
                        $ma->select('id', 'idmat', 'nommat', 'descrip');
                    },
                    'departamentos' => function($dep){
                        $dep->select('id','Nombre','departamento_id');
                    },
                    'claves' => function($cm){
                        $cm->select('id', 'CVE_ART', 'DESCR', 'UNI_MED', 'dep_mat_id');
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
        if(!empty($request->busca)){
            $clamat = dep_mat::where('departamento_id', '=', $request->busca)
                ->with([
                    'materiales' => function($ma){
                        $ma->select('id', 'idmat', 'nommat', 'descrip');
                    },
                    'departamentos' => function($dep){
                        $dep->select('id','Nombre','departamento_id');
                    },
                    'claves' => function($cm){
                        $cm->select('id', 'CVE_ART', 'DESCR', 'UNI_MED', 'dep_mat_id');
                    }
                ])
                ->get();
        }

        /***************************** consulta de claves de procesos **************************************************/
        $nclave = empty($request->cls) ? '' : claves::where('dep_mat_id', '=', $request->cls)
            ->get();

        /***************************** Consulta de todos los materiales que se tiene **********************************/
        $mate = materiales::get();

        return Inertia::render('Produccion/Clamat', ['usuario' => $perf, 'depa' => $depa, 'clamat' => $clamat, 'materiales' => $mate, 'ncla' => $nclave]);
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
            'departamento_id' => ['required'],
            'material_id' => ['required']
        ])->validate();

        $cuenta = dep_mat::where('departamento_id', '=', $request->departamento_id)
        ->where('material_id', '=', $request->material_id)
        ->withTrashed()
        ->first();
        if (!empty($cuenta)) {
            //revisa si el soft delete exite para restaurarlo
            if(!empty($cuenta->deleted_at))
            {
                $cuenta->restore();
            }//revisa si ya existe el usuario y el delete es nulo para mandar un aviso
            else{
                Validator::make($request->all(), [
                    'perfiles_usuarios_id' => 'unique:dep_mats'
                ])->validate();
            }
        }else{
            dep_mat::create($request->all());
        }


        return redirect()->back()
            ->with('message', 'Post Created Successfully.');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        if ($request->has('id')) {
            dep_mat::find($request->input('id'))->delete();
            return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
        }
    }
}
