<?php

namespace App\Http\Controllers\Compras\Papeleria;

use App\Http\Controllers\Controller;
use App\Models\Compras\Papeleria\ArticulosPapeleriaRequisicion;
use App\Models\Compras\Papeleria\MaterialPapeleria;
use App\Models\Compras\Papeleria\PapeleriaRequisicion;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Catalogos\JefesArea;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SolicitudesPapeleriaController extends Controller{

    public function index(Request $request){

        $hoy = Carbon::now();

        //Asigno el mes actual o uno recibido por request
        $request->Month == '' ? $mes = $hoy->format('n') : $mes = $request->Month;
        $request->Year == '' ? $anio = $hoy->format('Y') : $anio = $request->Year;

        $Session = auth()->user();

        $Material = MaterialPapeleria::orderBy('Nombre', 'asc')->get(['id','Nombre']);
        $Departamentos = Departamentos::orderBy('Nombre', 'asc')->get(['id','Nombre']);

        if($anio != 0 && $mes != 0){
            $Papeleria = ArticulosPapeleriaRequisicion::with([
                'ArticulosPapeleria' => function($Art) {
                    $Art->select('id', 'IdUser', 'IdEmp', 'Fecha', 'Folio', 'Perfil_id', 'Departamento_id',  'Comentarios');
                },
                'ArticuloMaterial' => function($Art) {
                    $Art->select('id', 'IdUser', 'Nombre', 'Unidad');
                },
                'ArticulosPapeleria.RequisicionDepartamento' => function($Art) {
                    $Art->select('id', 'IdUser', 'Nombre', 'departamento_id');
                },
                'ArticulosPapeleria.RequisicionPerfil' => function($Art) {
                    $Art->select('id', 'IdUser', 'Nombre', 'ApPat');
                },
            ])
            ->whereYear('created_at', $anio)
            ->whereMonth('created_at', $mes)
            ->where('Estatus', '>', 0)
            ->orderBy('id', 'desc')
            ->get(['id', 'Cantidad', 'material_id', 'papeleria_id', 'Estatus', 'created_at']);

            $Solicitud = (DB::select("
            SELECT M.Unidad, M.Nombre, SUM(A.Cantidad) AS Total FROM articulos_papeleria_requisicions AS A
            JOIN material_papelerias AS M
            ON A.material_id = M.id
            WHERE YEAR(A.created_at) = ".$anio."
            AND MONTH(A.created_at) = ".$mes."
            AND A.Estatus = 1
            GROUP BY M.Unidad, M.Nombre"));

        }elseif($anio == 0 && $mes != 0){
            $Papeleria = ArticulosPapeleriaRequisicion::with([
                'ArticulosPapeleria' => function($Art) {
                    $Art->select('id', 'IdUser', 'IdEmp', 'Fecha', 'Folio', 'Perfil_id', 'Departamento_id',  'Comentarios');
                },
                'ArticuloMaterial' => function($Art) {
                    $Art->select('id', 'IdUser', 'Nombre', 'Unidad');
                },
                'ArticulosPapeleria.RequisicionDepartamento' => function($Art) {
                    $Art->select('id', 'IdUser', 'Nombre', 'departamento_id');
                },
                'ArticulosPapeleria.RequisicionPerfil' => function($Art) {
                    $Art->select('id', 'IdUser', 'Nombre', 'ApPat');
                },
            ])
            ->whereMonth('created_at', $mes)
            ->where('Estatus', '>', 0)
            ->orderBy('id', 'desc')
            ->get(['id', 'Cantidad', 'material_id', 'papeleria_id', 'Estatus', 'created_at']);

            $Solicitud = (DB::select("
            SELECT M.Unidad, M.Nombre, SUM(A.Cantidad) AS Total FROM articulos_papeleria_requisicions AS A
            JOIN material_papelerias AS M
            ON A.material_id = M.id
            WHERE MONTH(A.created_at) = ".$mes."
            AND A.Estatus = 1
            GROUP BY M.Unidad, M.Nombre"));

        }elseif ($anio != 0 && $mes == 0) {
            $Papeleria = ArticulosPapeleriaRequisicion::with([
                'ArticulosPapeleria' => function($Art) {
                    $Art->select('id', 'IdUser', 'IdEmp', 'Fecha', 'Folio', 'Perfil_id', 'Departamento_id',  'Comentarios');
                },
                'ArticuloMaterial' => function($Art) {
                    $Art->select('id', 'IdUser', 'Nombre', 'Unidad');
                },
                'ArticulosPapeleria.RequisicionDepartamento' => function($Art) {
                    $Art->select('id', 'IdUser', 'Nombre', 'departamento_id');
                },
                'ArticulosPapeleria.RequisicionPerfil' => function($Art) {
                    $Art->select('id', 'IdUser', 'Nombre', 'ApPat');
                },
            ])
            ->whereYear('created_at', $anio)
            ->where('Estatus', '>', 0)
            ->orderBy('id', 'desc')
            ->get(['id', 'Cantidad', 'material_id', 'papeleria_id', 'Estatus', 'created_at']);

            $Solicitud = (DB::select("
            SELECT M.Unidad, M.Nombre, SUM(A.Cantidad) AS Total FROM articulos_papeleria_requisicions AS A
            JOIN material_papelerias AS M
            ON A.material_id = M.id
            WHERE YEAR(A.created_at) = ".$anio."
            AND A.Estatus = 1
            GROUP BY M.Unidad, M.Nombre"));
        }elseif ($anio == 0 && $mes == 0) {
            $Papeleria = ArticulosPapeleriaRequisicion::with([
                'ArticulosPapeleria' => function($Art) {
                    $Art->select('id', 'IdUser', 'IdEmp', 'Fecha', 'Folio', 'Perfil_id', 'Departamento_id',  'Comentarios');
                },
                'ArticuloMaterial' => function($Art) {
                    $Art->select('id', 'IdUser', 'Nombre', 'Unidad');
                },
                'ArticulosPapeleria.RequisicionDepartamento' => function($Art) {
                    $Art->select('id', 'IdUser', 'Nombre', 'departamento_id');
                },
                'ArticulosPapeleria.RequisicionPerfil' => function($Art) {
                    $Art->select('id', 'IdUser', 'Nombre', 'ApPat');
                },
            ])
            ->where('Estatus', '>', 0)
            ->orderBy('id', 'desc')
            ->get(['id', 'Cantidad', 'material_id', 'papeleria_id', 'Estatus', 'created_at']);

            $Solicitud = (DB::select("
            SELECT M.Unidad, M.Nombre, SUM(A.Cantidad) AS Total FROM articulos_papeleria_requisicions AS A
            JOIN material_papelerias AS M
            ON A.material_id = M.id
            AND A.Estatus = 1
            GROUP BY M.Unidad, M.Nombre"));
        }


        return Inertia::render('Compras/Papeleria/SolicitudPapeleria',
        compact('Session',
        'Departamentos' ,
        'Material',
        'Papeleria',
        'Solicitud',
        'anio',
        'mes'));
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

        $Papeleria = PapeleriaRequisicion::create([
            'IdUser' => $request->IdUser,
            'IdEmp' => $request->IdEmp,
            'Fecha' => $request->Fecha,
            'Departamento_id' => $request->Departamento_id,
            'jefes_areas_id' => $IdJefe,
            'Comentarios' => $request->Comentarios,
        ]);

        $PapeleriaId = $Papeleria->id;

        foreach ($request->Partida as $value) {
            $Articulos = ArticulosPapeleriaRequisicion::create([
                'Cantidad' => $value['Cantidad'],
                'material_id' => $value['Cantidad'],
                'papeleria_id' => $PapeleriaId,
            ]);
        }

        return redirect()->back();
    }

    public function update(Request $request, $id){

        switch ($request->metodo){
            case 2:
                ArticulosPapeleriaRequisicion::where('papeleria_id', '=', $request->id)->update([
                    'Estatus' => 2,
                ]);
                return redirect()->back();
                break;
            case 3:
                $User = User::where('IdEmp', '=', $request->User)->first(['id', 'IdEmp', 'password']);

                if(!empty($User->IdEmp)){
                    $User->IdEmp;
                    $User->password;
                    $User->id;

                    if($request->User == $User->IdEmp){
                        if (Hash::check($request->Pass, $User->password)){
                            //Contraseña y Uusario correctos
                            ArticulosPapeleriaRequisicion::where('papeleria_id', '=', $request->IdSolicitud)->update([
                                'Estatus' => 3,
                            ]);

                            PapeleriaRequisicion::where('id', '=', $request->IdSolicitud)->update([
                                'RecibidoPor' => $User->id,
                            ]);

                            return redirect()->back();
                            break;
                        }else{
                            return "Datos Incorrectos";
                        }
                    }else{
                        return "Datos Incorrectos";
                    }
                }
                break;
            case 4:
                ArticulosPapeleriaRequisicion::where('papeleria_id', '=', $request->IdSolicitud)->update([
                    'Estatus' => 4,
                ]);

                PapeleriaRequisicion::where('id', '=', $request->IdSolicitud)->update([
                    'MotivoRechazo' => $request->MotivoRechazo,
                ]);
                return redirect()->back();
            break;
        }
    }

    public function destroy($id){

    }
}
