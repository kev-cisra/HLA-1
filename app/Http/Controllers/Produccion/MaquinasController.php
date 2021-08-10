<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\Maquinas;
use App\Models\Produccion\are_prof;
use App\Models\Produccion\maq_pro;
use App\Models\RecursosHumanos\Catalogos\Areas;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MaquinasController extends Controller
{
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
            ->first();
        $maquinas = null;
        /*************** Información para mostrar áreas *************************/
        if($perf->Departamento_id == 2 && $perf->Puesto_id !== 16){
            //consulta las areas que le pertenecen al usuario
            $areas = are_prof::where('perfiles_usuarios_id','=',$perf->id)
                ->with([
                'areperf_area' => function($area){
                        $area->select('id', 'idArea', 'Nombre', 'tipo', 'areas_id');
                    }])
                ->get(['id','perfiles_usuarios_id', 'area_id']);
            /************************* Información de maquinas para coordinador, encargado y lider*************************/
            $maquinas = Maquinas::where('p');

        }else{
            //consulta el id de la area produccion
            $idarepro = Areas::where('idArea', '=', 'PRO')
                ->first();
            //muestra las areas y sub areas de produccion
            $areas = Areas::where('areas_id', '=', $idarepro->id)
                ->with('sub_areas')
                ->get(['id', 'IdUser', 'idArea', 'Nombre', 'areas_id']);
        }


        /*if(empty($request->busca)){
            foreach ($areas as $value) {
                return $value->areperf_area->id;
            }
        }*/

        return Inertia::render('Produccion/Maquinas', ['usuario' => $perf,'areas' => $areas, 'maquinas' => $maquinas]);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produccion\maq_pro  $maq_pro
     * @return \Illuminate\Http\Response
     */
    public function show(maq_pro $maq_pro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produccion\maq_pro  $maq_pro
     * @return \Illuminate\Http\Response
     */
    public function edit(maq_pro $maq_pro)
    {
        //
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produccion\maq_pro  $maq_pro
     * @return \Illuminate\Http\Response
     */
    public function destroy(maq_pro $maq_pro)
    {
        //
    }
}
