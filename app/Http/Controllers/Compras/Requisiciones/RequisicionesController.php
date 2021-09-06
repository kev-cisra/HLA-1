<?php

namespace App\Http\Controllers\Compras\Requisiciones;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\Maquinas;
use App\Models\Compras\Requisiciones\ArticulosRequisiciones;
use App\Models\Compras\Requisiciones\Requisiciones;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Catalogos\JefesArea;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Http\Request;
use Inertia\Inertia;
class RequisicionesController extends Controller{

    public function index(){

        $Session = auth()->user();
        $SessionIdEmp = $Session->IdEmp;

        //Consulta pra obtener el id de Jefe de acuerdo al numero de empleado del trabajador
        $ObtenJefe = JefesArea::where('IdEmp', '=', $SessionIdEmp)->first('id','IdEmp');
        if(!isset($ObtenJefe)){
            $IdJefe = $ObtenJefe->id; //Obtengo el id de trabajador de acuerdo al idEmpleado de la session

            //Consulta para obtener los datos de los trabajadores pertenecientes al id de la session
            $PerfilesUsuarios = PerfilesUsuarios::where('jefes_areas_id', '=', '12')->get();
        }else{
            $PerfilesUsuarios = PerfilesUsuarios::get();
        }

        $Departamentos = Departamentos::orderBy('Nombre', 'asc')->get(['id','Nombre']);
        $Maquinas = Maquinas::get(['id','Nombre']);

        $Perfiles = PerfilesUsuarios::where('jefes_areas_id', '=', $Session->id)->get();


        $ArticuloRequisicion = ArticulosRequisiciones::with([
            'ArticulosRequisicion' => function($req) { //Relacion 1 a 1 De puestos
                $req->select(
                    'id', 'IdUser',
                    'IdEmp', 'Folio',
                    'Fecha', 'NumReq',
                    'Departamento_id',
                    'jefes_areas_id',
                    'Codigo', 'Maquina_id',
                    'Marca_id', 'TipCompra',
                    'Observaciones',
                    'OrdenCompra', 'Perfil_id');
            },
            'ArticulosRequisicion.RequisicionesPerfil' => function($perfil) { //Relacion 1 a 1 De puestos
                $perfil->select('id', 'Nombre', 'ApPat', 'ApMat', 'jefes_areas_id');
            },
            'ArticulosRequisicion.RequisicionDepartamento' => function($departamento) { //Relacion 1 a 1 De puestos
                $departamento->select('id', 'Nombre');
            },
            'ArticulosRequisicion.RequisicionJefe' => function($jefe) { //Relacion 1 a 1 De puestos
                $jefe->select('id', 'Nombre');
            },
            'ArticulosRequisicion.RequisicionMaquina' => function($maquina) { //Relacion 1 a 1 De puestos
                $maquina->select('id', 'Nombre');
            },
            'ArticulosRequisicion.RequisicionMarca' => function($marca) { //Relacion 1 a 1 De puestos
                $marca->select('id', 'Nombre');
            },
        ])
        ->get(['id', 'Cantidad', 'Unidad', 'Descripcion', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'requisicion_id']);

        return Inertia::render('Compras/Requisiciones/index', compact('Session', 'PerfilesUsuarios', 'ArticuloRequisicion', 'Departamentos', 'Maquinas'));
    }

    public function create(){
    }

    public function store(Request $request){

        $Session = auth()->user();
        $SessionIdEmp = $Session->IdEmp;

        //Consulta pra obtener el id de Jefe de acuerdo al numero de empleado del trabajador
        $ObtenJefe = JefesArea::where('IdEmp', '=', $request->IdEmp)->first('id','IdEmp');
        if(!isset($ObtenJefe)){
            $IdJefe = $ObtenJefe->id; //Obtengo el id de trabajador de acuerdo al idEmpleado de la session
        }else{
            $PerfilesUsuarios = PerfilesUsuarios::where('IdEmp', '=', $request->IdEmp)->first('id','jefes_areas_id');
            $IdJefe = $ObtenJefe->id; //Obtengo el id de trabajador de acuerdo al idEmpleado de la session
        }

        //Genracion de folio automatico
        $Numfolio = Requisiciones::all(['Folio']);

        if($Numfolio->count()){
            $Nfolio = $Numfolio->last(); //Obtengo el ultimo folio con el metodo last

            foreach ($Nfolio as $item){
                $serial = $Nfolio->Folio; //asigno el folio a la variable serial
            }
        }else{
            $serial = 1000; //en caso de no haber registros asigno un folio
        }
        $serial += 1; //Incremento de folio

        $Requisicion = Requisiciones::create([
            'IdUser' => $request->IdUser,
            'IdEmp' => 5310,
            'Folio' => $serial,
            'Fecha' => $request->Fecha,
            'NumReq' => $request->NumReq,
            'Departamento_id' => $request->Departamento_id,
            'jefes_areas_id' => $IdJefe,
            'Codigo' => $request->Codigo,
            'Maquina_id' => $request->Maquina,
            'Marca_id' => $request->Marca,
            'TipCompra' => $request->Tipo,
            'Observaciones' => $request->Observaciones,
            'Perfil_id' => $request->Nombre,
        ]);

        $RequicisionId = $Requisicion->id;

        $Articulos = ArticulosRequisiciones::create([
            'Cantidad' => $request->Cantidad,
            'Unidad' => $request->Unidad,
            'Descripcion' => $request->Descripcion,
            'EstatusArt' => 0,
            'requisicion_id' => 1,
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
