<?php

namespace App\Http\Controllers\Almacen\Requisiciones;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\Maquinas;
use App\Models\Compras\Requisiciones\ArticulosRequisiciones;
use App\Models\Compras\Requisiciones\Requisiciones;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Catalogos\JefesArea;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use App\Models\Supply\Requisiciones\TiemposRequisiciones;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RequisicionesSolicitadasController extends Controller {

    public function index(Request $request){

        $hoy = Carbon::now();

        $request->month == '' ? $mes = $hoy->format('n') : $mes = $request->month;

        $Session = auth()->user();

        //Consulta pra obtener el id de Jefe de acuerdo al numero de empleado del trabajador
        $ObtenJefe = JefesArea::where('IdEmp', '=', $Session->IdEmp)->first(['id','IdEmp']);
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
                'ArticuloPrecios' => function($pre) { //Relacion 1 a 1 De puestos
                    $pre->select('id', 'Precio', 'Total', 'Marca', 'Proveedor', 'Comentarios', 'Archivo', 'Autorizado', 'articulos_requisiciones_id', 'requisiciones_id');
                },
                'ArticuloUser' => function($perfil) { //Relacion 1 a 1 De puestos
                    $perfil->select('id', 'name');
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
            ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'OrdenCompra', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id']);

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
                'ArticuloUser' => function($perfil) { //Relacion 1 a 1 De puestos
                    $perfil->select('id', 'name');
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
            ->get(['id', 'Fecha','Cantidad', 'Unidad', 'Descripcion', 'NumParte', 'EstatusArt', 'OrdenCompra', 'MotivoCancelacion', 'Resguardo', 'Fechallegada', 'Comentariollegada', 'RecibidoPor', 'requisicion_id']);

        }

        $pru = Requisiciones::with(['RequisicionArticulos', 'RequisicionesPerfil', 'RequisicionDepartamento', 'RequisicionJefe', 'RequisicionMaquina', 'RequisicionMarca'])->get();

        if($request->Req != ''){
            $Art = ArticulosRequisiciones::where('requisicion_id','=', $request->Req)->get();
        }else{
            $Art = ArticulosRequisiciones::get();
        }

        $Almacen = ArticulosRequisiciones::where('EstatusArt', '=', 8)->count();

        $Cotizacion = ArticulosRequisiciones::whereBetween('EstatusArt', [3, 4])->count();

        $SinConfirmar = ArticulosRequisiciones::where('EstatusArt', '=', 7)->count();

        return Inertia::render('Almacen/Requisiciones/Requisiciones', compact('Session', 'PerfilesUsuarios', 'ArticuloRequisicion', 'Departamentos', 'Maquinas', 'Almacen', 'Cotizacion', 'SinConfirmar', 'mes', 'pru', 'Art'));
    }

    public function store(Request $request){

        $hoy = Carbon::now();

        $Session = auth()->user();
        $SessionIdEmp = $Session->IdEmp;

        //Consulta pra obtener el id de Jefe de acuerdo al numero de empleado del trabajador
        $ObtenJefe = JefesArea::where('IdEmp', '=', $Session->IdEmp)->first('id','IdEmp');
        if(isset($ObtenJefe)){
            $IdJefe = $ObtenJefe->id; //Obtengo el Id del Jefe logueado
        }else{
            $PerfilesUsuarios = PerfilesUsuarios::where('IdEmp', '=', $Session->IdEmp)->first(['id','jefes_areas_id']);
            $IdJefe = $PerfilesUsuarios->jefes_areas_id; //Obtengo el Id de Jefe que corresponde a la session del empleado
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
            'IdUser' => $Session->id,
            'IdEmp' => $request->IdEmp,
            'Folio' => $serial,
            'NumReq' => $request->NumReq."-S",
            'Departamento_id' => $request->Dpto,
            'jefes_areas_id' => $IdJefe,
            'Codigo' => $request->Codigo,
            'Maquina_id' => $request->Maq,
            'Marca_id' => $request->Mar,
            'TipCompra' => $request->TipCompra,
            'Observaciones' => "Reposicion de Stock",
            'Perfil_id' => $Session->id,
        ]);

        $RequicisionId = $Requisicion->id;


        $Articulos = ArticulosRequisiciones::create([
            'IdEmp' => $Session->IdEmp,
            'Fecha' => $request->Fecha,
            'Cantidad' => $request->Cant,
            'Unidad' => $request->Uni,
            'NumParte' => $request->NumParte,
            'Descripcion' => $request->Desc,
            'EstatusArt' => 3,
            'requisicion_id' => $RequicisionId,
        ]);

        $ArticulosId = $Articulos->id;

        $TiempoReq = TiemposRequisiciones::create([
            'IdUser' => $Session->id,
            'IdEmp' => $Session->IdEmp,
            'requisicion_id' => $RequicisionId,
            'articulo_requisicion_id' => $ArticulosId,
        ]);

        return redirect()->back();
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

            switch ($request->metodo) {
                case 3:
                    ArticulosRequisiciones::find($request->id)->update([
                        'EstatusArt' => 3,
                    ]);

                    TiemposRequisiciones::where('articulo_requisicion_id', '=', $request->id)->update([
                        'Revision' => Carbon::now(),
                    ]);

                    break;


                case 8:
                    ArticulosRequisiciones::find($request->id)->update([
                        'EstatusArt' => 8,
                    ]);

                    TiemposRequisiciones::where('articulo_requisicion_id', '=', $request->id)->update([
                        'Almacen' => Carbon::now(),
                    ]);
                    break;

                case 9:
                    $User = User::where('IdEmp', '=', $request->User)->first(['id', 'IdEmp', 'password']);

                    if(!empty($User->IdEmp)){
                        $User->IdEmp;
                        $User->password;

                        if($request->User == $User->IdEmp){

                            if (Hash::check($request->Pass, $User->password)){
                                return back()->with([
                                    'flash' => 0,
                                ]);
                            }else{
                                return back()->with([
                                    'flash' => 3,
                                ]);
                            }
                        }else{
                            return back()->with([
                                'flash' => 2,
                            ]);
                        }
                    }else{
                        return back()->with([
                            'flash' => 1,
                        ]);
                    }
                    break;
                case 10:

                    $User = User::where('IdEmp', '=', $request->User)->first(['id', 'IdEmp', 'password']);

                    ArticulosRequisiciones::where('id', '=', $request->IdArt)->update([
                        'RecibidoPor' => $User->id,
                    ]);

                    ArticulosRequisiciones::find($request->IdArt)->update([
                        'EstatusArt' => 9,
                    ]);

                    TiemposRequisiciones::where('articulo_requisicion_id', '=', $request->IdArt)->update([
                        'Entregado' => Carbon::now(),
                    ]);

                    break;
            }

        }

        return redirect()->back();
    }

}
