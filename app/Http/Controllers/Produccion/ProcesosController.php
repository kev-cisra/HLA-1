<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Produccion\catalogos\procesos;
use App\Models\Produccion\dep_per;
use App\Models\Produccion\formulas;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class ProcesosController extends Controller
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
            ->first();

        $depa = NULL;
        $proce = NULL;

        /*************** Información para mostrar áreas *************************/
        if($perf->Departamento_id == 2 && $perf->Puesto_id !== 16){
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
            //se consultan las maquinas que estan en ese departamento
            $proce = procesos::where('departamento_id', '=', $prime->departamentos->id)
            ->with('departamentos', 'maq_pros')
            ->get();

        }else{
            //consulta el id de la area produccion
            $iddeppro = Departamentos::where('Nombre', '=', 'PRODUCCION')
                ->first();
            //muestra las areas y sub areas de produccion
            $depa = Departamentos::where('departamento_id', '=', $iddeppro->id)
                ->with('sub_Departamentos')
                ->get(['id', 'IdUser', 'Nombre', 'departamento_id']);
        }

        /**************************** consulta si existe la busqueda  ****************************************************/
        if(!empty($request->busca)){
            $proce = procesos::where('departamento_id', '=', $request->busca)
            ->with('departamentos', 'maq_pros')
            ->get();
        }
        return Inertia::render('Produccion/Procesos', ['usuario' => $perf,'procesos' => $proce,'depa' => $depa]);

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

        //echo $request['form'];
        Validator::make($request->all(), [
            'nompro' => ['required'],
            'areas_id' => ['required'],
            'tipo' => ['required'],
            'descripcion' => ['required'],
        ])->validate();

        procesos::create($request->all());

        /*return response()->json(['proceso_id' => $ins->id])
            ->setCallback();*/

        return redirect()->back()
            ->with('message', 'Post Created Successfully.');

        //procesos::create($request['form']->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produccion\procesos  $procesos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, procesos $procesos)
    {

        Validator::make($request->all(), [
            'nompro' => ['required'],
            'areas_id' => ['required'],
            'tipo' => ['required'],
            'descripcion' => ['required'],
        ])->validate();

        if ($request->has('id')) {
            procesos::find($request->input('id'))->update($request->all());
            return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produccion\procesos  $procesos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->has('id')) {
            procesos::find($request->input('id'))->delete();
            return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
        }
    }
}
