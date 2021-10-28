<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\Maquinas;
use App\Models\Produccion\catalogos\procesos;
use App\Models\Produccion\dep_per;
use App\Models\Produccion\formulas;
use App\Models\Produccion\maq_pro;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\Return_;

class ProcesosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Produccion.procesos.index']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        //Muestra el id de la persona que inicio sesion
        $usuario = Auth::id();
        //muestra la información del usuario que inicio sesion
        $perf = PerfilesUsuarios::where('user_id','=',$usuario)
            ->with('dep_pers')
            ->first();
        //return count($perf->dep_pers);
        $depa = [];
        $proce = [];
        $maq = [];
        //condicion para usuarios $perf->Departamento_id == 2 && $perf->Puesto_id != 16
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
            /* $prime = dep_per::where('perfiles_usuarios_id','=',$perf->id)
                ->with([
                    'departamentos' => function($dep){
                        $dep->select('id');
                    }])
                ->first(['id', 'departamento_id']);
            //se consultan las maquinas que estan en ese departamento
            $proce = procesos::where('departamento_id', '=', $prime->departamentos->id)
            ->with([
                'departamentos' => function($dep){
                    $dep->select('id', 'Nombre', 'departamento_id');
                },
                'sub_proceso',
                'formulas.maq_pros.maquinas',
                'formulas.proc_rela',
                'maq_pros' => function($mp){
                    $mp->select('id', 'proceso_id', 'maquina_id')
                    ->with('maquinas');
                }
                ])
            ->get(); */
            /**************************** Consulta si existe maquinas *****************************************************/
            /* $maq = Maquinas::where('departamento_id', '=', $prime->departamentos->id)
                ->with([
                    'marca'=> function($maq){
                        $maq->select('id', 'Nombre', 'maquinas_id');
                    }
                ])
                ->get(['id', 'Nombre', 'departamento_id']); */
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
            $proce = procesos::where('departamento_id', '=', $request->busca)
            ->with([
                'departamentos' => function($dep){
                    $dep->select('id', 'Nombre', 'departamento_id');
                },
                'sub_proceso',
                'formulas.maq_pros.maquinas',
                'formulas.proc_rela',
                'maq_pros' => function($mp){
                    $mp->select('id', 'proceso_id', 'maquina_id')
                    ->with('maquinas');
                }
                ])
            ->get();
            /**************************** Consulta si existe maquinas *****************************************************/
            $maq = Maquinas::where('departamento_id', '=', $request->busca)
                ->with([
                    'marca'=> function($maq){
                        $maq->select('id', 'Nombre', 'maquinas_id');
                    }
                ])
                ->get(['id', 'Nombre', 'departamento_id']);
        }


        return Inertia::render('Produccion/Procesos', ['usuario' => $perf,'procesos' => $proce,'depa' => $depa, 'maquinas' => $maq]);

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
        //return $request;
        Validator::make($request->all(), [
            'nompro' => ['required'],
            'departamento_id' => ['required'],
            'tipo' => ['required']
        ])->validate();
        if ($request->tipo == 3) {
            Validator::make($request->all(), [
                'operacion' => ['required']
            ])->validate();
        }elseif ($request->tipo != 0) {
            Validator::make($request->all(), [
                'proceso_id' => ['required']
            ])->validate();
        }

        //CARGA DE PROCESOS
        $proceso = procesos::create($request->all());

        //CARGA DEPENDIENDO DEL TIPO
        if ($request->tipo == 1 || $request->tipo == 2 || $request->tipo == 5) {
            foreach ($request->maquinas as $value) {
                if ($value['value'] != null) {
                    maq_pro::create([
                        'proceso_id' => $proceso->id,
                        'maquina_id' => $value['value'],
                    ]);
                }
            }
        }elseif($request->tipo == 3){
            foreach ($request->formulas as $for) {
                //echo $for['val'];
                foreach ($request->for_maq as $check) {
                    $ch = explode('-', $check);
                    //si los procesos a cargar tienen maquinas
                    if ($for['val'] == $ch[0]) {
                        //echo $for['val'].' '.$check.' '.'maquinas - ';
                        formulas::create([
                            'proc_rela' => $for['val'],
                            'maq_pros_id' => $ch[1],
                            'proceso_id' => $proceso->id
                        ]);
                    }
                    //en caso de que no cuente con maquinas
                    else{
                        /* consulta el tipo de proceso  */
                        $tipo = procesos::where('id', '=', $for['val'])
                            ->first();
                        //en caso de que sea proceso principal o formula va a insertar
                        if ($tipo->tipo == 0 | $tipo->tipo == 3) {
                            //consulta si ese proceso ya existe de lo contrario lo omite
                            $ver = formulas::where('proceso_id', '=', $proceso->id)
                                ->where('proc_rela', '=', $for['val'])
                                ->count();
                            if ($ver == 0) {
                                //echo 'T'.$tipo->tipo.' '.$for['val'].' '.$check.' '.'procesos - ';
                                formulas::create([
                                    'proc_rela' => $for['val'],
                                    'proceso_id' => $proceso->id
                                ]);
                            }
                        }
                    }
                }
            }
        }

        //return $request;
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
            'departamento_id' => ['required'],
            'tipo' => ['required'],
        ])->validate();

        //actualiza los procesos
        if ($request->has('id')) {
            procesos::find($request->input('id'))->update($request->all());
            /* return redirect()->back()
                    ->with('message', 'Post Updated Successfully.'); */
        }

        if ($request->tipo == 1 || $request->tipo == 2 || $request->tipo == 5) {
            //recorrido de la base de datos
            $mpS = maq_pro::where('proceso_id', '=', $request->id)
                ->withTrashed()
                ->get(['id', 'proceso_id', 'maquina_id', 'deleted_at']);
            $sv = array();
            foreach ($request->maquinas as $v) {
                array_push($sv,strval($v['value']));
            }
            foreach ($request->maquinas as $val) {
                echo 'entro';
                if (count($mpS) == 0) {
                    maq_pro::create([
                        'proceso_id' => $request->id,
                        'maquina_id' => $val['value'],
                    ]);
                }
                else{
                    foreach ($mpS as $vS) {

                        //recorrido de request
                        $mpR = maq_pro::where('proceso_id', '=', $request->id)
                        ->where('maquina_id', '=', $val['value'])
                        ->withTrashed()
                        ->first(['id', 'proceso_id', 'maquina_id', 'deleted_at']);
                        if ($val['value'] != $vS->maquina_id) {
                            //echo $mpR;
                            if (empty($mpR)) {
                                echo 'insert';
                                maq_pro::create([
                                    'proceso_id' => $request->id,
                                    'maquina_id' => $val['value'],
                                ]);
                            }
                            //echo $vS->maquina_id . ' - ' . in_array($vS->maquina_id,$sv).'/ ';
                            if(empty(in_array($vS->maquina_id,$sv)) & !empty($mpR) & empty($vS->deleted_at)){
                                //echo 'delet';
                                maq_pro::where('proceso_id', '=', $request->id)
                                    ->where('maquina_id', '=', $vS->maquina_id)
                                    ->delete();
                            }
                        }else{

                            //recorrido de request
                            $mpR = maq_pro::where('proceso_id', '=', $request->id)
                            ->where('maquina_id', '=', $val['value'])
                            ->withTrashed()
                            ->first(['id', 'proceso_id', 'maquina_id', 'deleted_at']);
                            //revisa si el soft delete exite para restaurarlo
                            if(!empty($mpR->deleted_at))
                            {
                                //echo 'restaura';
                                $mpR->restore();
                            }
                        }
                    }
                }
            }

            return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
            /* return($sv); */

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
