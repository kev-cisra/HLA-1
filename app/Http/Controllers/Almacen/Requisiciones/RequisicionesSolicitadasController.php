<?php

namespace App\Http\Controllers\Almacen\Requisiciones;

use App\Http\Controllers\Controller;
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

class RequisicionesSolicitadasController extends Controller {

    public function index(Request $request){

        $hoy = Carbon::now();

        $request->month == '' ? $mes = $hoy->format('n') : $mes = $request->month;

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
            ->orderBy('EstatusArt', 'asc')
            ->where('EstatusArt', '!=', 1)
            ->whereMonth('Fecha', $mes)
            ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'requisicion_id']);

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
            ->orderBy('EstatusArt', 'asc')
            ->where('EstatusArt', '!=', 1)
            ->where('EstatusArt', $request->Estatus)
            ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'EstatusArt', 'MotivoCancelacion', 'Resguardo', 'requisicion_id']);

        }

        $Almacen = ArticulosRequisiciones::where('EstatusArt', '=', 3)->count();

        $Cotizacion = ArticulosRequisiciones::where('EstatusArt', '=', 4)->count();

        $Autorizados = ArticulosRequisiciones::where('EstatusArt', '=', 5)->count();


        return Inertia::render('Almacen/Requisiciones/Requisiciones', compact('Session', 'PerfilesUsuarios', 'ArticuloRequisicion', 'Departamentos', 'Maquinas', 'Almacen', 'Cotizacion', 'Autorizados', 'mes'));
    }

    public function update(Request $request, $id){



        if($request->metodo == 'Parcialidad'){

            $id = $request->IdArt;

            //Obtengo la cantidad solicitada previamente
            $Articulo = ArticulosRequisiciones::where('id', '=', $request->IdArt)->first();
            $Articulo->Cantidad;

            //Resto la diferencia que existen en almacen
            $Par = $Articulo->Cantidad - $request->Parcialidad;

            ArticulosRequisiciones::where('id', '=', $id)->update([
                'Cantidad' => $Par,
            ]);

            $Parcialidad = ArticulosRequisiciones::create([
                'Fecha' => $Articulo->Fecha,
                'Cantidad' => $request->Parcialidad,
                'Unidad' => $Articulo->Unidad,
                'Descripcion' => $Articulo->Descripcion,
                'EstatusArt' => $Articulo->EstatusArt,
                'requisicion_id' => $Articulo->requisicion_id,
            ]);

        }else{
            ArticulosRequisiciones::find($request->id)->update([
                'EstatusArt' => 3,
            ]);
        }

        return redirect()->back();
    }

}
