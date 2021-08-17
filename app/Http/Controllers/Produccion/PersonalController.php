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
        //muestra las areas y sub areas de produccion
        $areas = Departamentos::where('Nombre', '=', 'OPERACIONES')
            ->with('sub_Departamentos')
            ->get(['id', 'IdUser', 'Nombre', 'departamento_id']);
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



        return Inertia::render('Produccion/Personal', ['usuario' => $perf, 'areas' => $areas, 'personal' => $personal, 'areper' => $areper]);
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
        // crea un nuevo usuario para que ocupe la aplicación
        //return $request->departamentos['Nombre'];
        $n_user = User::create([
            'IdEmp' => $request->perfiles['IdEmp'],
            'name' => $request->perfiles['Nombre'].' '.$request->perfiles['ApPat'].' '.$request->perfiles['ApMat'],
            'Departamento' => $request->departamentos['Nombre'],
            'password' => bcrypt($request->perfiles['IdEmp'])
        ]);
        //actualiza la informacion de perfiles para relacionar con el nuevo usuario
        PerfilesUsuarios::find($request->perfiles['id'])->update(['user_id' => $n_user->id]);
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
            dep_per::find($request->input('id'))->delete();
            return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
        }
    }
}
