<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\Maquinas;
use App\Models\Catalogos\MarcasMaquinas;
use App\Models\Produccion\dep_per;
use App\Models\Produccion\maq_pro;
use App\Models\RecursosHumanos\Catalogos\Areas;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class MaquinasController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Produccion.maquinas.index|admin.index']);
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
        $maquinas = null;
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
                    }
                ])
                ->first(['id', 'departamento_id']);
            //se consultan las maquinas que estan en ese departamento
            $maquinas = Maquinas::where('departamento_id', '=', $prime->departamentos->id)
            ->with([
                'departamentos',
                'marca' => function($mar){
                    $mar->select('id', 'Nombre', 'maquinas_id');
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


        if(!empty($request->busca)){
            $maquinas = Maquinas::where('departamento_id', '=', $request->busca)
            ->with([
                'departamentos',
                'marca' => function($mar){
                    $mar->select('id', 'Nombre', 'maquinas_id');
                }
            ])
            ->get();
        }

        return Inertia::render('Produccion/Maquinas', ['usuario' => $perf,'depa' => $depa, 'maquinas' => $maquinas]);
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
            'Nombre' => ['required'],
            'Departamento' => 'required',
            'marca' => 'required'
        ])->validate();
        //return $request;
        $maq = Maquinas::create([
            'IdUser' => $request->IdUser,
            'departamento_id' => $request->departamento_id,
            'Nombre' => strtoupper($request->Nombre),
            'Departamento' => $request->Departamento
        ]);

        MarcasMaquinas::create([
            'IdUser' => $request->IdUser,
            'Nombre' => $request->marca,
            'maquinas_id' => $maq->id
        ]);

        return redirect()->back()
            ->with('message', 'Post Created Successfully.');/**/
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produccion\maq_pro  $maq_pro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, maq_pro $maq_pro)
    {
        //
        Validator::make($request->all(), [
            'departamento_id' => 'required',
            'Nombre' => ['required'],
            'Departamento' => 'required',
            'marca' => 'required'
        ])->validate();

        if ($request->has('id')) {
            Maquinas::find($request->input('id'))->update([
                'IdUser' => $request->IdUser,
                'departamento_id' => $request->departamento_id,
                'Nombre' => strtoupper($request->Nombre),
                'Departamento' => $request->Departamento
            ]);

            MarcasMaquinas::where('maquinas_id', '=', $request->id)->update([
                'Nombre' => $request->marca
            ]);
            return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produccion\maq_pro  $maq_pro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        if ($request->has('id')) {
            Maquinas::find($request->input('id'))->delete();
            return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
        }
    }
}
