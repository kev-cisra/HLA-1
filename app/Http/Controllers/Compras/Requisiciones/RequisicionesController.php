<?php

namespace App\Http\Controllers\Compras\Requisiciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Compras\Requisiciones\RequisicionesRequest;
use App\Models\Catalogos\Maquinas;
use App\Models\Compras\Requisiciones\ArticulosRequisiciones;
use App\Models\Compras\Requisiciones\Requisiciones;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Catalogos\JefesArea;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RequisicionesController extends Controller{

    public function index(Request $request){

        $hoy = Carbon::now();

        $request->month == '' ? $mes = $hoy->format('n') : $mes = $request->month;

        $Session = auth()->user();
        $SessionIdEmp = $Session->IdEmp;

        //Consulta pra obtener el id de Jefe de acuerdo al numero de empleado del trabajador
        $ObtenJefe = JefesArea::where('IdEmp', '=', $SessionIdEmp)->first('id','IdEmp');

        if(isset($ObtenJefe)){
            $IdJefe = $ObtenJefe->id; //Obtengo el id de trabajador de acuerdo al idEmpleado de la session

            //Consulta para obtener los datos de los trabajadores pertenecientes al id de la session
            $PerfilesUsuarios = PerfilesUsuarios::where('jefes_areas_id', '=', $IdJefe)->get();
        }else{
            $PerfilesUsuarios = PerfilesUsuarios::get();
        }

        $Departamentos = Departamentos::orderBy('Nombre', 'asc')->get(['id','Nombre']);
        $Maquinas = Maquinas::get(['id','Nombre']);

        $Perfiles = PerfilesUsuarios::where('jefes_areas_id', '=', $Session->id)->get();

        if($request->Estatus == ''){

            $ArticuloRequisicion = ArticulosRequisiciones::with([
                'ArticulosRequisicion' => function($req) { //Relacion 1 a 1 De puestos
                    $req->select(
                        'id', 'IdUser',
                        'IdEmp', 'Folio',
                        'NumReq',
                        'Departamento_id',
                        'jefes_areas_id',
                        'Codigo', 'Maquina_id',
                        'Marca_id', 'TipCompra',
                        'Observaciones', 'Perfil_id');
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
            ->where('IdEmp', '=', $Session->IdEmp)
            ->orderBy('EstatusArt', 'asc')
            ->whereMonth('Fecha', $mes)
            ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id']);

        }else{

            $ArticuloRequisicion = ArticulosRequisiciones::with([
                'ArticulosRequisicion' => function($req) { //Relacion 1 a 1 De puestos
                    $req->select(
                        'id', 'IdUser',
                        'IdEmp', 'Folio',
                        'NumReq',
                        'Departamento_id',
                        'jefes_areas_id',
                        'Codigo', 'Maquina_id',
                        'Marca_id', 'TipCompra',
                        'Observaciones', 'Perfil_id');
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
            ->where('IdEmp', '=', $Session->IdEmp)
            ->orderBy('EstatusArt', 'asc')
            ->where('EstatusArt', $request->Estatus)
            ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id']);

        }



        $Almacen = ArticulosRequisiciones::where('EstatusArt', '=', 3)->count();

        $Cotizacion = ArticulosRequisiciones::where('EstatusArt', '=', 4)->count();

        $Autorizados = ArticulosRequisiciones::where('EstatusArt', '=', 5)->count();

        return Inertia::render('Compras/Requisiciones/index', compact('Session', 'PerfilesUsuarios', 'ArticuloRequisicion', 'Departamentos', 'Maquinas', 'Almacen', 'Cotizacion', 'Autorizados', 'mes'));
    }

    public function store(RequisicionesRequest $request){

        $Session = auth()->user();
        $SessionIdEmp = $Session->IdEmp;

        //Consulta pra obtener el id de Jefe de acuerdo al numero de empleado del trabajador
        $ObtenJefe = JefesArea::where('IdEmp', '=', $request->IdEmp)->first('id','IdEmp');
        if(isset($ObtenJefe)){
            $IdJefe = $ObtenJefe->id; //Obtengo el id de trabajador de acuerdo al idEmpleado de la session
        }else{
            $PerfilesUsuarios = PerfilesUsuarios::where('IdEmp', '=', $request->IdEmp)->first('id','jefes_areas_id');
            $IdJefe = $PerfilesUsuarios->id; //Obtengo el id de trabajador de acuerdo al idEmpleado de la session
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
            'IdEmp' => $Session->IdEmp,
            'Folio' => $serial,
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

        foreach ($request->Partida as $value) {
            $Articulos = ArticulosRequisiciones::create([
                'IdEmp' => $Session->IdEmp,
                'Fecha' => $request->Fecha,
                'Cantidad' => $value['Cantidad'],
                'Unidad' => $value['Unidad'],
                'Descripcion' => $value['Descripcion'],
                'EstatusArt' => 1,
                'requisicion_id' => $RequicisionId,
            ]);
        }

        return redirect()->back();
    }

    public function update(Request $request, $id){

        switch($request->metodo){
            case 1:

                Validator::make($request->all(), [
                    'IdUser' => ['required'],
                    'IdEmp' => ['required'],
                    'Fecha' => ['required'],
                    'Departamento_id' => ['required'],
                    'NumReq' => ['numeric','required','digits_between:4,5'],
                    'Codigo' => ['required'],
                    'Maquina' => ['required'],
                    'Marca' => ['required'],
                    'Tipo' => ['required'],
                    'Nombre' => ['required'],
                    'Marca' => ['required'],
                    'Observaciones' => ['required'],
                ])->validate();

                $ReqId = ArticulosRequisiciones::where('id', '=', $request->editId)->first('requisicion_id');

                Requisiciones::find($ReqId->requisicion_id)->update([

                    'IdUser' => $request->IdUser,
                    'Departamento_id' => $request->Departamento_id,
                    'NumReq' => $request->NumReq,
                    'Codigo' => $request->Codigo,
                    'Maquina_id' => $request->Maquina,
                    'Marca_id' => $request->Marca,
                    'TipCompra' => $request->Tipo,
                    'Perfil_id' => $request->Nombre,
                    'Observaciones ' => $request->Observaciones,
                ]);

                ArticulosRequisiciones::find($request->editId)->update([
                    'Fecha' => $request->Fecha,
                    'Cantidad' => $request->Cantidad,
                    'Unidad' => $request->Unidad,
                    'Descripcion' => $request->Descripcion,
                ]);

                return redirect()->back();

                break;

            case 2:

                $ReqId = ArticulosRequisiciones::where('id', '=', $request->id)->first('requisicion_id');

                ArticulosRequisiciones::where('requisicion_id', '=', $ReqId->requisicion_id)->update([
                    'EstatusArt' => 2,
                ]);

                return redirect()->back();

                break;
        }

    }

    public function destroy($id)
    {
        //
    }
}
