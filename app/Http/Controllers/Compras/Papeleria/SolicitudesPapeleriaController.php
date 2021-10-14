<?php

namespace App\Http\Controllers\Compras\Papeleria;

use App\Http\Controllers\Controller;
use App\Models\Compras\Papeleria\ArticulosPapeleriaRequisicion;
use App\Models\Compras\Papeleria\MaterialPapeleria;
use App\Models\Compras\Papeleria\PapeleriaRequisicion;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Catalogos\JefesArea;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SolicitudesPapeleriaController extends Controller{

    public function index(){

        $hoy = Carbon::now();

        $mes = $hoy->format('n');

        $Session = auth()->user();

        $Material = MaterialPapeleria::orderBy('Nombre', 'asc')->get(['id','Nombre']);
        $Departamentos = Departamentos::orderBy('Nombre', 'asc')->get(['id','Nombre']);

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
                $Art->select('id', 'IdUser', 'Nombre');
            },
        ])
        ->where('Estatus', '>', 0)
        ->orderBy('id', 'desc')
        ->get(['id', 'Cantidad', 'material_id', 'papeleria_id', 'Estatus']);

        $Solicitud = (DB::select("
        SELECT M.Unidad, M.Nombre, SUM(A.Cantidad) AS Total FROM articulos_papeleria_requisicions AS A
        JOIN material_papelerias AS M
        ON A.material_id = M.id
        WHERE MONTH(A.created_at) = ".$mes."
        AND A.Estatus = 1
        GROUP BY M.Unidad, M.Nombre"));


        return Inertia::render('Compras/Papeleria/SolicitudPapeleria', compact('Session', 'Departamentos' , 'Material', 'Papeleria', 'Solicitud'));
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
                ArticulosPapeleriaRequisicion::where('id', '=', $request->id)->update([
                    'Estatus' => 2,
                ]);
                break;
            case 3:
                ArticulosPapeleriaRequisicion::where('id', '=', $request->id)->update([
                    'Estatus' => 3,
                ]);
                break;
        }

        return redirect()->back();
    }

    public function destroy($id){

    }
}
