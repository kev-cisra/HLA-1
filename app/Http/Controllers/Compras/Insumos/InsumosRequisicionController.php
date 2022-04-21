<?php

namespace App\Http\Controllers\Compras\Insumos;

use App\Http\Controllers\Controller;
use App\Models\Compras\Insumos\ArticulosRequisicionesInsumos;
use App\Models\Compras\Insumos\Insumos;
use App\Models\Compras\Insumos\RequisicionesInsumos;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use stdClass;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class InsumosRequisicionController extends Controller{

    public function index(Request $request){

        $Session = auth()->user();
        $User = User::find($Session->id); //Accedo a los datos del usuario logueado
        $Autorizado = $User->hasAnyRole(['ONEPIECE', 'ADMINISTRADOR', 'SISTEMAS', 'SUPPLY']); //Busco si el suaurio tiene alguno de los siguientes Roles

        if($Autorizado == true){ //Usuario Admin
            //Catalogos
            $Departamentos = Departamentos::whereIn('id',[ 7, 8, 9, 12, 13, 23, 25, 27, 29])->get(['id', 'Nombre']);
            $Insumos = Insumos::get();

            //Consulta Principal
            $RequisicionesInsumos = RequisicionesInsumos::with([
                'Perfil' => function($Perfil) { //Relacion 1 a 1 De puestos
                    $Perfil->select('id', 'Nombre', 'ApPat', 'ApMat');
                },
                'Departamento' => function($Departamento) { //Relacion 1 a 1 De puestos
                    $Departamento->select('id', 'Nombre');
                },
                'Articulos' => function($Articulos) { //Relacion 1 a 1 De puestos
                    $Articulos->select('id', 'IdUser', 'Cantidad', 'Estatus', 'insumo_id', 'requisiciones_insumos_id');
                },
                'Articulos.Insumo' => function($Articulos) { //Relacion 1 a 1 De puestos
                    $Articulos->select('id', 'IdUser', 'Clave', 'Nombre', 'Linea', 'Unidad');
                }
            ])->get();
        }else{
            //Catalogos
            if($User->hasRole('CoordinadorTejido') == true){
            $Departamentos = Departamentos::where('id',13)->get(['id', 'Nombre']);
            }elseif($User->hasRole('CoordinadorCalidad') == true){
                $Departamentos = Departamentos::where('id',9)->get(['id', 'Nombre']);
            }else {
                $Departamentos = Departamentos::whereIn('id',[ 7, 8, 9, 12, 13, 23, 25, 27, 29])->get(['id', 'Nombre']);
            }

            $Insumos = Insumos::get();
            //Obtengo el id del perfil
            $Perfil = PerfilesUsuarios::where('user_id', '=', $Session->id)->first('id');

            //Consulta Principal
            $RequisicionesInsumos = RequisicionesInsumos::with([
                'Perfil' => function($Perfil) { //Relacion 1 a 1 De puestos
                    $Perfil->select('id', 'Nombre', 'ApPat', 'ApMat');
                },
                'Departamento' => function($Departamento) { //Relacion 1 a 1 De puestos
                    $Departamento->select('id', 'Nombre');
                },
                'Articulos' => function($Articulos) { //Relacion 1 a 1 De puestos
                    $Articulos->select('id', 'IdUser', 'Cantidad', 'Estatus', 'insumo_id', 'requisiciones_insumos_id');
                },
                'Articulos.Insumo' => function($Articulos) { //Relacion 1 a 1 De puestos
                    $Articulos->select('id', 'IdUser', 'Clave', 'Nombre', 'Linea', 'Unidad');
                }
            ])->where('Perfil_id', '=',$Perfil->id)
            ->get();
        }

        if($request->Req){

            $RequisicionInsumo = RequisicionesInsumos::with([
                'Perfil' => function($Perfil) { //Relacion 1 a 1 De puestos
                    $Perfil->select('id', 'Nombre', 'ApPat', 'ApMat');
                },
                'Departamento' => function($Departamento) { //Relacion 1 a 1 De puestos
                    $Departamento->select('id', 'Nombre');
                },
                'Articulos' => function($Articulos) { //Relacion 1 a 1 De puestos
                    $Articulos->select('id', 'IdUser', 'Cantidad', 'Estatus', 'insumo_id', 'requisiciones_insumos_id');
                },
                'Articulos.Insumo' => function($Articulos) { //Relacion 1 a 1 De puestos
                    $Articulos->select('id', 'IdUser', 'Clave', 'Nombre', 'Linea', 'Unidad');
                }
            ])->where('id', '=', $request->Req)->first();

        }else{
            $RequisicionInsumo = new stdClass();
        }

        return Inertia::render('Compras/Insumos/RequisicionInsumos', compact('Session', 'Departamentos', 'Insumos', 'RequisicionesInsumos', 'RequisicionInsumo'));
    }

    public function store(Request $request){

        Validator::make($request->all(),[
            'IdUser' => ['required'],
            'Fecha' => ['required'],
            'Departamento_id' => ['required'],
        ])->validate();

        $CreaRequi = 0;
        $Session = auth()->user();
        $hoy = Carbon::now();
        $anio = $hoy->format('y');

        $Perfil_id = PerfilesUsuarios::where('user_id','=',$request->IdUser)->first('id');

        $Numfolio = RequisicionesInsumos::all(['Folio']);

        if($Numfolio->count()){ //Verifico que existe al menos un folio

            $Nfolio = $Numfolio->last(); //Obtengo el ultimo folio con el metodo last
            $AnioBd = substr($Nfolio->Folio, 0, 2); //Obtengo el año del folio

            $serial = $Nfolio->Folio; //asigno el folio a la variable serial
            $serial = substr($serial, 2); //Obtengo el folio sin el año

            $AnioBd == $anio ?  $serial += 1 :  $serial = 1;

        }else{
            $serial = 1; //en caso de no haber registros asigno un folio
        }

        foreach ($request->Partida as $value) { //Verifico que se envien datos en la partida
            if( $value['Cantidad'] != '' && $value['insumo_id'] != ''){
                $CreaRequi = 1;
            }else{
                $CreaRequi = 0;
            }
        }

        if($CreaRequi == 1){ //Si hay datos en la partidas se procede a generar la requisicion

            $Requisicion = RequisicionesInsumos::create([
                'IdUser' => $request->IdUser,
                'Fecha' => $request->Fecha,
                'Folio' => $anio . $serial,
                'Estatus' => 1,
                'Perfil_id' => $Perfil_id->id,
                'Departamento_id' => $request->Departamento_id,
            ]);
            $requisicion_id = $Requisicion->id;

            foreach ($request->Partida as $value) {

                ArticulosRequisicionesInsumos::create([
                    'IdUser' => $request->IdUser,
                    'Cantidad' => $value['Cantidad'],
                    'Estatus' => 1,
                    'requisiciones_insumos_id' => $requisicion_id,
                    'insumo_id' => $value['insumo_id'],
                ]);
            }

        }else{ //Caso contrario de manda un mensaje de Session
            session()->flash('flash.type', 'Warning');
            session()->flash('flash.message', 'Por favor Verifique la información capturada');
        }

        return redirect()->back();
    }

    public function update(Request $request, $id){
        $Session = auth()->user();
        $User = User::find($Session->id); //Accedo a los datos del usuario logueado
        $Actualiza = 0;

        switch ($request->Metodo) {
            case 1:
                RequisicionesInsumos::find($request->id)->update([
                    'Estatus' => 2,
                ]);

                ArticulosRequisicionesInsumos::where('requisiciones_insumos_id', '=', $request->id)->update([
                    'Estatus' => 2,
                ]);

                return redirect()->back();
                break;

            case 2:
                // Verificacion de datos en partidas
                foreach ($request->Partida as $value) {
                    if($value['Cantidad'] != '' && $value['insumo_id'] != ''){
                        $Actualiza = 1;
                    }else{
                        $Actualiza = 0;
                    }
                }

                if($Actualiza == 1){

                    $Requisicion = RequisicionesInsumos::where('id', $request->Req_id)->update([
                        'IdUser' => $request->IdUser,
                        'Fecha' => $request->Fecha,
                        'Departamento_id' => $request->Departamento_id,
                    ]);

                    foreach ($request->Partida as $value) {
                        //Verificacion de datos a actualizar
                        if(isset($value['Art_id'])){
                            $ArticuloInsumo = ArticulosRequisicionesInsumos::where('id', $value['Art_id'])->update([
                                'Cantidad' => $value['Cantidad'],
                                'insumo_id' => $value['insumo_id'],
                            ]);
                        }else{ //Nuevas partidas añadidas
                            // return $request;
                            //Insersion de nuevas partidas a la requisicion
                            ArticulosRequisicionesInsumos::create([
                                'IdUser' => $Session->id,
                                'Cantidad' => $value['Cantidad'],
                                'Estatus' => 1,
                                'requisiciones_insumos_id' => $request->Req_id,
                                'insumo_id' => $value['insumo_id'],
                            ]);
                        }

                    }
                    return redirect()->back();
                    break;
                }else{
                    return "Revisa los datos introducidos";
                }
        }
    }
}
