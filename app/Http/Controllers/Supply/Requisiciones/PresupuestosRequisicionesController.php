<?php

namespace App\Http\Controllers\Supply\Requisiciones;

use App\Http\Controllers\Controller;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\Supply\Presupuestos\Presupuesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class PresupuestosRequisicionesController extends Controller
{

    public function index(Request $request){
        $Session = auth()->user();
        $Departamentos = Departamentos::get();

        if($request->dpto == ''){
            $Presupuestos = Presupuesto::with('PresupuestoDepartamento')->get();
        }else{
            $Presupuestos = Presupuesto::with('PresupuestoDepartamento')->where('Departamento_id', '=', $request->dpto)->get();
        }

        return Inertia::render('Supply/Presupuestos/Presupuestos', compact('Session', 'Departamentos', 'Presupuestos'));
    }

    public function store(Request $request){

        $date = Carbon::now();
        $año = $date->format('Y');

        Validator::make($request->all(), [
            'Departamento_id' => ['required'],
            'Mes' => ['required'],
            'Presupuesto' => ['required'],
        ])->validate();

        // return $request;

        $ValidadMes = Presupuesto::where('Departamento_id', '=', $request->Departamento_id)
        ->where('Anio', '=', $año)
        ->where('Mes', '=', $request->Mes)
        ->get();

        if(count($ValidadMes) == 0){
            Presupuesto::create([
                'IdUser' => $request->IdUser,
                'Departamento_id'  => $request->Departamento_id,
                'Anio' => $año,
                'Mes'  => $request->Mes,
                'Presupuesto'  => $request->Presupuesto,
            ]);
            return redirect()->back()->with(['flash' => 0]);;

        }else{
            return back()->with(['flash' => 1]);
        }
    }

    public function update(Request $request, $id){

        Validator::make($request->all(), [
            'Departamento_id' => ['required'],
            'Mes' => ['required'],
            'Presupuesto' => ['required'],
        ])->validate();

        if ($request->has('id')) {
            Presupuesto::find($request->input('id'))->update($request->all());
            return redirect()->back();
        }
    }

    public function destroy(Request $request){
        if ($request->has('id')) {
            Presupuesto::find($request->input('id'))->delete();
            return redirect()->back();
        }
    }
}
