<?php

namespace App\Http\Controllers\Sistemas\Hardware;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use App\Models\Sistemas\Hardware\HardwareAsignado;
use App\Models\Sistemas\Hardware\HardwareSistemas;
use App\Models\Sistemas\Hardware\ResguardoSistemas;
use Illuminate\Http\Request;
use Inertia\Inertia;
use stdClass;

class EquiposAsignadosController extends Controller{

    public function index(Request $request){

        $Session = auth()->user();

        //Catalogos
        $Hardware = HardwareSistemas::get(['id', 'Nombre', 'Marca', 'Modelo', 'Comentarios']);
        $Perfiles = PerfilesUsuarios::get(['id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat']);

        //Consulta Principal
        $EquiposAsignados = HardwareAsignado::with([
            'Perfil' => function($prov) { //Relacion 1 a 1 De puestos
                $prov->select('id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat');
            },
            'Hardware' => function($articulo) { //Relacion 1 a 1 De puestos
                $articulo->select('id', 'Nombre');
            }
        ])->get(['id', 'IdUser', 'FechaAsignacion', 'SubArea', 'Ubicacion', 'Comentarios', 'Estatus', 'Hardware_id', 'Perfil_id']);


        if (!empty($request->busca)){
            $EquipoAsignado = HardwareAsignado::with([
                'Hardware' => function($articulo) { //Relacion 1 a 1 De puestos
                    $articulo->select('id', 'Nombre', 'Marca', 'Modelo', 'NumeroSerie', 'Comentarios');
                }
            ])->where('Perfil_id', $request->busca)
            ->get(['id', 'IdUser', 'FechaAsignacion', 'SubArea', 'Ubicacion', 'Comentarios', 'Estatus', 'Hardware_id', 'Perfil_id']);
            $Resguardo = ResguardoSistemas::where('Perfil_id', $request->busca)->first();
        }else{
            $EquipoAsignado = new stdClass();
            $Resguardo = new stdClass();
        }

        return Inertia::render('Sistemas/Equipos/EquiposAsignados', compact('Session', 'Hardware', 'Perfiles', 'EquiposAsignados', 'EquipoAsignado', 'Resguardo'));
    }

    public function store(Request $request){

        Validator::make($request->all(), [
            'IdUser' => ['required'],
            'FechaAsignacion' => ['required','date'],
            'SubArea' => ['required'],
            'Ubicacion' => ['required'],
            'Perfil_id' => ['required'],
            'Hardware_id' => ['required'],
        ])->validate();

        HardwareAsignado::create($request->all());
        return redirect()->back();
    }

    public function update(Request $request, $id){

        Validator::make($request->all(), [
            'IdUser' => ['required'],
            'FechaAsignacion' => ['required','date'],
            'SubArea' => ['required'],
            'Ubicacion' => ['required'],
            'Perfil_id' => ['required'],
            'Hardware_id' => ['required'],
        ])->validate();

        if ($request->has('id')) {
            HardwareAsignado::find($request->id)->update($request->all());
        }
        return redirect()->back();
    }

    public function destroy(Request $request, $id){

        if ($request->has('id')) {
            HardwareAsignado::find($request->id)->update(['Estatus' => 0]);
        }

        return redirect()->back();
    }

}
