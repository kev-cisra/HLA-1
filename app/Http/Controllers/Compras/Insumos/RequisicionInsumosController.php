<?php

namespace App\Http\Controllers\Compras\Insumos;

use App\Http\Controllers\Controller;
use App\Models\Compras\Insumos\Insumos;
use App\Models\Compras\Insumos\RequisicionInsumos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
class RequisicionInsumosController extends Controller{

    public function index(){

        $Session = auth()->user();

        if(count($Session->roles) != 0){
            $Rol = $Session->roles[0]->name;
        }else{
            $Rol = "SINROLASIGNADO";
        }

        if($Rol == 'ONEPIECE' || $Rol == 'Administrador'){
            $Insumos = Insumos::where('Departamento_id', '=', 7)->get(['id', 'IdUser', 'Nombre', 'Unidad', 'Departamento_id']);

            $NumInsumos = Insumos::where('Departamento_id', '=', 7)->count();

            $ReqInsumos = RequisicionInsumos::with('RequisicionesInsumosMaterial', 'RequisicionesInsumosPerfil', 'RequisicionInsumosDepartamento')->get();

        }else{
            $Insumos = Insumos::where('Departamento_id', '=', $Session->Departamento)->get(['id', 'IdUser', 'Nombre', 'Unidad', 'Departamento_id']);

            $NumInsumos = Insumos::where('Departamento_id', '=', $Session->Departamento)->count();

            $ReqInsumos = RequisicionInsumos::with([
                'RequisicionesInsumosMaterial' => function($req) { //Relacion 1 a 1 De puestos
                    $req->select(
                        'id', 'IdUser',
                        'IdEmp', 'Departamento_id',
                        'Insumo_id',
                        'Cantidad',
                        'Estatus');
                },
                'RequisicionesInsumosPerfil' => function($perfil) { //Relacion 1 a 1 De puestos
                    $perfil->select('id', 'IdUser', 'IdEmp','Nombre', 'ApPat', 'ApMat');
                },
                'RequisicionInsumosDepartamento' => function($perfil) { //Relacion 1 a 1 De puestos
                    $perfil->select('id', 'IdUser', 'Nombre', 'departamento_id');
                }
            ])
            ->where('IdEmp', '=', $Session->IdEmp)
            ->get(['id', 'IdUser', 'IdEmp', 'Departamento_id', 'Insumo_id', 'Cantidad', 'Estatus']);


        }

        return Inertia::render('Compras/Insumos/RequisicionInsumos', compact('Session', 'Insumos', 'NumInsumos', 'ReqInsumos'));
    }

    public function store(Request $request){

        $Session = auth()->user();

        if(isset($request->Ins1)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 1,
                'Cantidad' => $request->Ins1,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins2)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 2,
                'Cantidad' => $request->Ins2,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins3)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 3,
                'Cantidad' => $request->Ins3,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins4)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 4,
                'Cantidad' => $request->Ins4,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins5)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 5,
                'Cantidad' => $request->Ins5,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins6)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 6,
                'Cantidad' => $request->Ins6,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins7)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 7,
                'Cantidad' => $request->Ins7,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins8)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 8,
                'Cantidad' => $request->Ins8,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins9)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 9,
                'Cantidad' => $request->Ins9,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins10)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 10,
                'Cantidad' => $request->Ins10,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins11)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 11,
                'Cantidad' => $request->Ins11,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins12)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 12,
                'Cantidad' => $request->Ins12,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins13)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 13,
                'Cantidad' => $request->Ins13,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins14)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 14,
                'Cantidad' => $request->Ins14,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins15)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 15,
                'Cantidad' => $request->Ins15,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins16)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 16,
                'Cantidad' => $request->Ins16,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins17)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 17,
                'Cantidad' => $request->Ins17,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins18)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 18,
                'Cantidad' => $request->Ins18,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins19)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 19,
                'Cantidad' => $request->Ins19,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins20)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 20,
                'Cantidad' => $request->Ins20,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins21)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 21,
                'Cantidad' => $request->Ins21,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins22)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 22,
                'Cantidad' => $request->Ins22,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins23)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 23,
                'Cantidad' => $request->Ins23,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins24)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 24,
                'Cantidad' => $request->Ins24,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins25)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 25,
                'Cantidad' => $request->Ins25,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins26)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 26,
                'Cantidad' => $request->Ins26,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins27)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 27,
                'Cantidad' => $request->Ins27,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins28)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 28,
                'Cantidad' => $request->Ins28,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins29)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 29,
                'Cantidad' => $request->Ins29,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins30)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 30,
                'Cantidad' => $request->Ins30,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins31)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 31,
                'Cantidad' => $request->Ins31,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins32)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 32,
                'Cantidad' => $request->Ins32,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins33)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 33,
                'Cantidad' => $request->Ins33,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins34)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 34,
                'Cantidad' => $request->Ins34,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins35)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 35,
                'Cantidad' => $request->Ins35,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins36)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 36,
                'Cantidad' => $request->Ins36,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins37)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 37,
                'Cantidad' => $request->Ins37,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins38)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 38,
                'Cantidad' => $request->Ins38,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins39)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 39,
                'Cantidad' => $request->Ins39,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins40)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 40,
                'Cantidad' => $request->Ins40,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins41)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 41,
                'Cantidad' => $request->Ins41,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins42)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Departamento_id' => $Session->Departamento,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 42,
                'Cantidad' => $request->Ins42,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins43)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 43,
                'Cantidad' => $request->Ins43,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins44)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 44,
                'Cantidad' => $request->Ins44,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins45)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 45,
                'Cantidad' => $request->Ins45,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins46)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 46,
                'Cantidad' => $request->Ins46,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins47)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 47,
                'Cantidad' => $request->Ins47,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins48)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 48,
                'Cantidad' => $request->Ins48,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins49)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 49,
                'Cantidad' => $request->Ins49,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins50)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 50,
                'Cantidad' => $request->Ins50,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins51)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 51,
                'Cantidad' => $request->Ins51,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins52)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 52,
                'Cantidad' => $request->Ins52,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins53)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Insumo_id' => 53,
                'Cantidad' => $request->Ins53,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins54)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 54,
                'Cantidad' => $request->Ins54,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins55)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 55,
                'Cantidad' => $request->Ins55,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins56)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 56,
                'Cantidad' => $request->Ins56,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins57)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 57,
                'Cantidad' => $request->Ins57,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins58)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 5,
                'Cantidad' => $request->Ins58,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins59)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 59,
                'Cantidad' => $request->Ins59,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins60)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 60,
                'Cantidad' => $request->Ins60,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins61)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 61,
                'Cantidad' => $request->Ins61,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins62)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 62,
                'Cantidad' => $request->Ins62,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins63)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 63,
                'Cantidad' => $request->Ins63,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins64)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 64,
                'Cantidad' => $request->Ins64,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins65)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 65,
                'Cantidad' => $request->Ins65,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins66)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 66,
                'Cantidad' => $request->Ins66,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins67)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 67,
                'Cantidad' => $request->Ins67,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins68)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 68,
                'Cantidad' => $request->Ins68,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins69)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 69,
                'Cantidad' => $request->Ins69,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins70)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 70,
                'Cantidad' => $request->Ins70,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins71)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 71,
                'Cantidad' => $request->Ins71,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins72)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 72,
                'Cantidad' => $request->Ins72,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins73)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 73,
                'Cantidad' => $request->Ins73,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins74)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 74,
                'Cantidad' => $request->Ins74,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins75)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Departamento_id' => $Session->Departamento,
                'Insumo_id' => 75,
                'Cantidad' => $request->Ins75,
                'Estatus' => 0,
            ]);
        }

        return redirect()->back();
    }
}
