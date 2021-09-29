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

class RequisicionPapeleriaController extends Controller{

    public function index(){

        $Session = auth()->user();
        $IdEmp = $Session->id;

        $Material = MaterialPapeleria::all();
        $Departamentos = Departamentos::orderBy('Nombre', 'asc')->get(['id','Nombre']);

        $Papeleria = ArticulosPapeleriaRequisicion::with([
            'ArticulosPapeleria' => function($Art) {
                $Art->select('id', 'IdUser', 'IdEmp', 'Departamento_id', 'jefes_areas_id', 'Fecha', 'Comentarios');
            },
            'ArticuloMaterial' => function($Art) {
                $Art->select('id', 'IdUser', 'Nombre', 'Unidad');
            },
            'ArticulosPapeleria.RequisicionDepartamento' => function($Art) { //Relacion 1 a 1 De puestos
                $Art->select('id', 'IdUser', 'Nombre', 'departamento_id');
            },
            'ArticulosPapeleria.RequisicionJefe' => function($Art) { //Relacion 1 a 1 De puestos
                $Art->select('id', 'IdUser', 'Nombre', 'Area');
            },
        ])->where('IdEmp', '=', $Session->IdEmp)
        ->get(['id', 'IdEmp', 'Cantidad', 'material_id', 'papeleria_id', 'Estatus']);

        return Inertia::render('Compras/Papeleria/RequisicionPapeleria', compact('Session', 'Departamentos' , 'Material', 'Papeleria'));
    }

    public function store(Request $request){

        $Session = auth()->user();
        $SessionIdEmp = $Session->IdEmp;

        //Consulta pra obtener el id de Jefe de acuerdo al numero de empleado del trabajador
        $ObtenJefe = JefesArea::where('IdEmp', '=', $request->IdEmp)->first('id','IdEmp');
        if(!empty($ObtenJefe)){
            $IdJefe = $ObtenJefe->id; //Obtengo el id de trabajador de acuerdo al idEmpleado de la session
        }else{
            $PerfilesUsuarios = PerfilesUsuarios::where('IdEmp', '=', $request->IdEmp)->first('id','jefes_areas_id');
            $IdJefe = $PerfilesUsuarios->jefes_areas_id; //Obtengo el id de trabajador de acuerdo al idEmpleado de la session
        }

        $Papeleria = PapeleriaRequisicion::create([
            'Fecha' => date('Y-m-d'),
            'IdUser' => $request->IdUser,
            'IdEmp' => $request->IdEmp,
            'Departamento_id' => $request->Departamento_id,
            'jefes_areas_id' => $IdJefe,
            'Comentarios' => $request->Comentarios,
        ]);

        $PapeleriaId = $Papeleria->id;

        foreach ($request->Partida as $value) {
            $Articulos = ArticulosPapeleriaRequisicion::create([
                'IdEmp' => $Session->IdEmp,
                'Cantidad' => $value['Cantidad'],
                'material_id' => $value['Material'],
                'papeleria_id' => $PapeleriaId,
            ]);
        }

        return redirect()->back();
    }

    public function update(Request $request, $id){

        if(isset($request->metodo)){

            switch ($request->metodo){
                case 1:
                    ArticulosPapeleriaRequisicion::where('id', '=', $request->id)->update([
                        'Estatus' => 1,
                    ]);
                break;
            }
        }else{
            PapeleriaRequisicion::find($request->ReqId)->update([
                'Departamento_id' => $request->Departamento_id,
                'Comentarios' => $request->Comentarios,
            ]);

            ArticulosPapeleriaRequisicion::find($request->ArtId)->update([
                'Cantidad' => $request->Cantidad,
                'material_id' => $request->Material,
            ]);
        }

        return redirect()->back();
    }

    public function destroy($id){

    }
}
