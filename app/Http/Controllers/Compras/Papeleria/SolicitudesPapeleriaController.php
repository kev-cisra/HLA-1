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

class SolicitudesPapeleriaController extends Controller{

    public function index(){

        $Session = auth()->user();

        $Material = MaterialPapeleria::orderBy('Nombre', 'asc')->get(['id','Nombre']);
        $Departamentos = Departamentos::orderBy('Nombre', 'asc')->get(['id','Nombre']);

        $Papeleria = ArticulosPapeleriaRequisicion::with('ArticulosPapeleria', 'ArticuloMaterial' , 'ArticulosPapeleria.RequisicionDepartamento', 'ArticulosPapeleria.RequisicionJefe')->get();

        return Inertia::render('Compras/Papeleria/SolicitudPapeleria', compact('Session', 'Departamentos' , 'Material', 'Papeleria'));
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

        PapeleriaRequisicion::find($request->ReqId)->update([
            'Fecha' => $request->Fecha,
            'Departamento_id' => $request->Departamento_id,
            'Comentarios' => $request->Comentarios,
        ]);

        ArticulosPapeleriaRequisicion::find($request->ArtId)->update([
            'Cantidad' => $request->Cantidad,
            'material_id' => $request->Material,
        ]);

        return redirect()->back();
    }

    public function destroy($id){

    }
}
