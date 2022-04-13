<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Produccion\dep_per;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class PersonalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Produccion.personal.index|admin.index']);
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

        $depa = NULL;
        if (count($perf->dep_pers) != 0) {
            //consulta las areas que le pertenecen al usuario
            $depa = dep_per::where('perfiles_usuarios_id','=',$perf->id)
                ->with([
                'departamentos' => function($dep){
                        $dep->select('id', 'Nombre', 'departamento_id');
                    }])
                ->get(['id','perfiles_usuarios_id', 'departamento_id']);
        }else{
            //muestra las areas y sub areas de produccion
            $depa = Departamentos::where('Nombre', '=', 'OPERACIONES')
                ->with('sub_Departamentos')
                ->get(['id', 'IdUser', 'Nombre', 'departamento_id']);
        }

        //consulta a todos los usuarios qu pertenecen a operaciones
        $personal = PerfilesUsuarios::where('Departamento_id', '=', $request->busca)
            ->get();

        //consulta a la relacion de areas y usuarios
        $areper = empty($request->busca) ? NULL : dep_per::where('departamento_id', '=', $request->busca)
        ->with([
            'departamentos' => function($area){
                $area->select('id', 'Nombre', 'departamento_id');
            },
            'perfiles' => function($perfi){
                $perfi->select('id', 'IdEmp','Empresa', 'Nombre', 'ApPat', 'ApMat', 'user_id');
            }])
        ->get();



        return Inertia::render('Produccion/Personal', ['usuario' => $perf, 'areas' => $depa, 'personal' => $personal, 'areper' => $areper]);
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
                'ope_puesto' => 'required',
                'perfiles_usuarios_id' => ['required','numeric'],
        ])->validate();

        switch ($request->ope_puesto) {
            case 'cor':
                $per = 'Cordinador';
                break;
            case 'enc':
                $per = 'Encargado';
                break;
            case 'lid':
                $per = 'Lider';
                break;
            case 'ope':
                $per = 'Operador';
                break;
        }

        $user = PerfilesUsuarios::where( 'id', '=', $request->perfiles_usuarios_id)
            ->with([
                'perfil_user'
            ])
            ->first(['id', 'user_id']);
        if($user->perfil_user->hasRole('Produccion')) {
            $user->perfil_user->removeRole('Produccion');
            $user->perfil_user->removeRole($per);
        }

        $user->perfil_user->assignRole(['Produccion', $per]);

        //return $user->perfil_user->hasRole('Operador');

        //consulta si ya esta registrado ese usuario
        $cuenta = dep_per::where('perfiles_usuarios_id', '=', $request->perfiles_usuarios_id)
        ->withTrashed ()
        ->where('departamento_id', '=', $request->departamento_id)
        ->first();

        //revisa si la consulta anterior no es vacias
        if(!empty($cuenta)) {
            //revisa si el soft delete exite para restaurarlo
            if(!empty($cuenta->deleted_at))
            {
                $cuenta->restore();
                $cuenta->update(['ope_puesto' => $request->ope_puesto]);
            }//revisa si ya existe el usuario y el delete es nulo para mandar un aviso
            else{
                Validator::make($request->all(), [
                    'perfiles_usuarios_id' => 'unique:dep_pers'
                ])->validate();
            }
        }//si no existe ningun dato crea un nuevo registro
        else {
            dep_per::create($request->all());
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
        $user = User::find($request->perfiles['user_id']);
        if($user->hasRole('Operador')){
            dep_per::find($request->id)->update(['ope_puesto' => 'lid']);
            $user->removeRole('Operador');
            $user->assignRole('Lider');
        }elseif ($user->hasRole('Lider')) {
            dep_per::find($request->id)->update(['ope_puesto' => 'ope']);
            $user->removeRole('Lider');
            $user->assignRole('Operador');
        }
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
        $user = User::find($request->perfiles['user_id']);
        //return $request;
        switch ($request->ope_puesto) {
            case 'cor':
                $per = 'Cordinador';
                break;
            case 'enc':
                $per = 'Encargado';
                break;
            case 'lid':
                $per = 'Lider';
                break;
            case 'ope':
                $per = 'Operador';
                break;
        }
        if($user->hasRole('Produccion')) {
            $user->removeRole('Produccion');
            $user->removeRole($per);
        }
        if ($request->has('id')) {
            dep_per::find($request->input('id'))->delete();
            return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
        }
    }
}
