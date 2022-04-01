<?php

namespace App\Http\Controllers\Sistemas\Requisiciones;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use App\Models\Sistemas\Hardware\HardwareSistemas;
use App\Models\Sistemas\Requisiciones\ArticulosRequisicionesSistemas;
use App\Models\Sistemas\Requisiciones\RequisicionesSistemas;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
class RequisicionesSistemasController extends Controller{

    public function index(){
        $Session = auth()->user();
        $User = User::find($Session->id); //Accedo a los datos del usuario logueado
        $Autorizado = $User->hasAnyRole(['ONEPIECE', 'ADMINISTRADOR', 'SUPPLY']); //Busco si el suaurio tiene alguno de los siguientes Roles

        if($Autorizado == true){
            $ReqSistemas = RequisicionesSistemas::with([
                'Perfil' => function($Perfil) { //Relacion 1 a 1 De puestos
                    $Perfil->select('id', 'Nombre', 'ApPat', 'ApMat');
                },
                'Departamento' => function($Departamento) { //Relacion 1 a 1 De puestos
                    $Departamento->select('id', 'Nombre');
                },
                'Articulos' => function($Articulos) { //Relacion 1 a 1 De puestos
                    $Articulos->select('id', 'IdUser', 'Cantidad', 'Unidad', 'Dispositivo', 'requisicion_sistemas_id');
                }
            ])->get();
        }else{
            $ReqSistemas = RequisicionesSistemas::with([
                'Perfil' => function($Perfil) { //Relacion 1 a 1 De puestos
                    $Perfil->select('id', 'Nombre', 'ApPat', 'ApMat');
                },
                'Departamento' => function($Departamento) { //Relacion 1 a 1 De puestos
                    $Departamento->select('id', 'Nombre');
                },
                'Articulos' => function($Articulos) { //Relacion 1 a 1 De puestos
                    $Articulos->select('id', 'IdUser', 'Cantidad', 'Unidad', 'Dispositivo', 'requisicion_sistemas_id');
                }
            ])->where('IdUser',$User->id)->get();
        }

        $Departamentos = Departamentos::where('id', '=', $Session->Departamento)->get(['id', 'Nombre']);
        $Hardware = HardwareSistemas::get(['id', 'Nombre']);

        return Inertia::render('Sistemas/Requisiciones/RequisicionesSistemas', compact('Session', 'Departamentos', 'Hardware', 'ReqSistemas'));
    }

    public function store(Request $request){

        Validator::make($request->all(), [
            'IdUser' => ['required'],
            'Fecha' => ['required','date'],
            'Estatus' => ['required'],
            'Departamento_id' => ['required'],
            'Partida.Cantidad.*' => ['required'],
            'Partida.Unidad.*' => ['required'],
            'Partida.Dispositivo.*' => ['required'],
        ])->validate();

        $CreaRequi = 0;
        $Session = auth()->user();
        $Perfil_id = PerfilesUsuarios::where('user_id','=',$request->IdUser)->first('id');
        //Genracion de folio automatico
        $Numfolio = RequisicionesSistemas::all(['Folio']);

        if($Numfolio->count()){
            $Nfolio = $Numfolio->last(); //Obtengo el ultimo folio con el metodo last
            foreach ($Nfolio as $item){
                $serial = $Nfolio->Folio; //asigno el folio a la variable serial
            }
        }else{
            $serial = 1; //en caso de no haber registros asigno un folio
        }

        $serial += 1; //Incremento de folio

        foreach ($request->Partida as $value) { //Verifico que se envien datos en la partida
            if( $value['Cantidad'] != '' && $value['Unidad'] != '' && $value['Dispositivo'] != ''){
                $CreaRequi = 1;
            }else{
                $CreaRequi = 0;
            }
        }

        if($CreaRequi == 1){ //Si hay datos en la partida se guardan
            $Requisicion = RequisicionesSistemas::create([
                'IdUser' => $request->IdUser,
                'Fecha' => $request->Fecha,
                'Folio' => $serial,
                'Estatus' => $request->Estatus,
                'Perfil_id' => $Perfil_id->id,
                'Departamento_id' => $request->Departamento_id,
                'Comentarios' => $request->Comentarios,
            ]);
            $requisicion_id = $Requisicion->id;

            foreach ($request->Partida as $value) {

                ArticulosRequisicionesSistemas::create([
                    'IdUser' => $request->IdUser,
                    'Cantidad' => $value['Cantidad'],
                    'Unidad' => $value['Unidad'],
                    'Dispositivo' => $value['Dispositivo'],
                    'requisicion_sistemas_id' => $requisicion_id,
                ]);
            }

        }else{ //Caso contrario de manda un mensaje de Session
            session()->flash('flash.type', 'Warning');
            session()->flash('flash.message', 'Por favor Verifique la información capturada');
        }
        return redirect()->back();
    }

    public function update(Request $request, $id){

        switch ($request->Metodo) {
            case 1: //Actualizacion de estatuz a Confirmado
                RequisicionesSistemas::find($request->id)->update([
                    'Estatus' => 1,
                ]);
                return redirect()->back();
                break;
            case 2: //Edicion de Partida
                RequisicionesSistemas::find($request->requisicion_sistemas_id)->update([
                    'Fecha' => $request->Fecha,
                    'Departamento_id' => $request->Departamento_id,
                    'Comentarios' => $request->Comentarios,
                ]);

                foreach ($request->Partida as $value) {

                    ArticulosRequisicionesSistemas::where('requisicion_sistemas_id', '=', $request->requisicion_sistemas_id)->update([
                        'IdUser' => $request->IdUser,
                        'Cantidad' => $value['Cantidad'],
                        'Unidad' => $value['Unidad'],
                        'Dispositivo' => $value['Dispositivo'],
                    ]);
                }
                return redirect()->back();
                break;
        }
    }

    public function destroy($id){

    }
}
