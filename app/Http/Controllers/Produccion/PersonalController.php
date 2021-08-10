<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Produccion\dep_perf;
use App\Models\RecursosHumanos\Catalogos\Areas;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class PersonalController extends Controller
{
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
        ->get();
        //consulta el id de la area produccion
        $idarepro = Departamentos::where('Nombre', '=', 'OPERACIONES')
            ->first();
        //muestra las areas y sub areas de produccion
        $areas = Departamentos::where('departamento_id', '=', $idarepro->id)
            ->with('sub_Departamentos')
            ->get(['id', 'IdUser', 'Nombre', 'departamento_id']);
        //consulta a todos los usuarios qu pertenecen a operaciones
        $personal = PerfilesUsuarios::where('Departamento_id', '=', 2)
            ->get();
        //consulta a la relacion de areas y usuarios
        $areper = empty($request->busca) ? NULL : dep_perf::where('departamento_id', '=', $request->busca)
        ->with([
            'areperf_area' => function($area){
                $area->select('id', 'Nombre', 'tipo', 'departamento_id');
            },
            'areperf_perfil' => function($perfi){
                $perfi->select('id', 'IdEmp','Empresa', 'Nombre', 'ApPat', 'ApMat', 'user_id');
            }])
        ->get();



        return Inertia::render('Produccion/Personal', ['usuario' => $perf, 'areas' => $areas, 'personal' => $personal, 'areper' => $areper]);
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
                'departamento_id' => 'required',
                'perfiles_usuarios_id' => ['required','numeric'],
        ])->validate();
        //consulta si ya esta registrado ese usuario
        $cuenta = dep_perf::where('perfiles_usuarios_id', '=', $request->perfiles_usuarios_id)
        ->withTrashed ()
        ->where('departamento_id', '=', $request->area_id)
        ->first();
        //revisa si la consulta anterior no es vacias
        if(!empty($cuenta)) {
            //revisa si el soft delete exite para restaurarlo
            if(!empty($cuenta->deleted_at))
            {
                $cuenta->restore();
            }//revisa si ya existe el usuario y el delete es nulo para mandar un aviso
            else{
                Validator::make($request->all(), [
                    'perfiles_usuarios_id' => 'unique:dep_perfs'
                ])->validate();
            }
        }//si no existe ningun dato crea un nuevo registro
        else {
            dep_perf::create($request->all());
        }

        return redirect()->back()
            ->with('message', 'Post Created Successfully.');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produccion\are_prof  $are_prof
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // crea un nuevo usuario para que ocupe la aplicación
        $n_user = User::create([
            'IdEmp' => $request->IdEmp,
            'name' => $request->Nombre.' '.$request->ApPat.' '.$request->ApMat,
            'Area' => '',
            'email' => '',
            'password' => bcrypt($request->IdEmp)
        ]);
        //actualiza la informacion de perfiles para relacionar con el nuevo usuario
        PerfilesUsuarios::find($request->id)->update(['user_id' => $n_user->id]);
        return redirect()->back()
            ->with('message', 'Post Created Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produccion\are_prof  $are_prof
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        if ($request->has('id')) {
            dep_perf::find($request->input('id'))->delete();
            return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
        }
    }
}
