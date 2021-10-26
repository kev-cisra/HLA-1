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
        ->where('IdEmp', '=', $Session->IdEmp)
        ->orderBy('id', 'desc')
        ->get(['id', 'Cantidad', 'material_id', 'papeleria_id', 'Estatus']);

        return Inertia::render('Compras/Papeleria/RequisicionPapeleria', compact('Session', 'Departamentos' , 'Material', 'Papeleria'));
    }

    public function store(Request $request){

        $Session = auth()->user();


        Validator::make($request->all(), [
            'Departamento_id' => ['required'],
        ])->validate();

        $Perfil = PerfilesUsuarios::where('IdEmp', '=', $Session->IdEmp)->get();

        //Genracion de folio automatico
        $Numfolio = PapeleriaRequisicion::all(['Folio']);

        if($Numfolio->count()){
            $Nfolio = $Numfolio->last(); //Obtengo el ultimo folio con el metodo last

            foreach ($Nfolio as $item){
                $serial = $Nfolio->Folio; //asigno el folio a la variable serial
            }
        }else{
            $serial = 1000; //en caso de no haber registros asigno un folio
        }
        $serial += 1; //Incremento de folio

        $Papeleria = PapeleriaRequisicion::create([
            'Fecha' => date('Y-m-d'),
            'Folio' => $serial,
            'IdUser' => $request->IdUser,
            'IdEmp' => $request->IdEmp,
            'Perfil_id' => $Perfil[0]->id,
            'Departamento_id' => $request->Departamento_id,
            'Comentarios' => $request->Comentarios,
        ]);

        $PapeleriaId = $Papeleria->id;

        foreach ($request->Partida as $value) {
            if(isset($value['Cantidad'])){
                $Articulos = ArticulosPapeleriaRequisicion::create([
                    'IdEmp' => $Session->IdEmp,
                    'Cantidad' => $value['Cantidad'],
                    'material_id' => $value['Material'],
                    'papeleria_id' => $PapeleriaId,
                ]);
            }
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
