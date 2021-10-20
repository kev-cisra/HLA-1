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
        }else{
            $Insumos = Insumos::where('Departamento_id', '=', $Session->Departamento)->get(['id', 'IdUser', 'Nombre', 'Unidad', 'Departamento_id']);
            $NumInsumos = Insumos::where('Departamento_id', '=', $Session->Departamento)->count();
        }

        return Inertia::render('Compras/Insumos/RequisicionInsumos', compact('Session', 'Insumos', 'NumInsumos'));
    }

    public function store(Request $request){

        if(isset($request->Ins1)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Insumo_id' => 1,
                'Cantidad' => $request->Ins1,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins2)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Insumo_id' => 2,
                'Cantidad' => $request->Ins2,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins3)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Insumo_id' => 3,
                'Cantidad' => $request->Ins3,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins4)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Insumo_id' => 4,
                'Cantidad' => $request->Ins4,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins5)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Insumo_id' => 5,
                'Cantidad' => $request->Ins5,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins6)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Insumo_id' => 6,
                'Cantidad' => $request->Ins6,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins7)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Insumo_id' => 7,
                'Cantidad' => $request->Ins7,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins8)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Insumo_id' => 8,
                'Cantidad' => $request->Ins8,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins9)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Insumo_id' => 9,
                'Cantidad' => $request->Ins9,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins10)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Insumo_id' => 10,
                'Cantidad' => $request->Ins10,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins11)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Insumo_id' => 11,
                'Cantidad' => $request->Ins11,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins12)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Insumo_id' => 12,
                'Cantidad' => $request->Ins12,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins13)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Insumo_id' => 13,
                'Cantidad' => $request->Ins13,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins14)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Insumo_id' => 14,
                'Cantidad' => $request->Ins14,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins15)){
            $Insumos = RequisicionInsumos::create([
                'IdUser' => $request->IdUser,
                'IdEmp' => $request->IdEmp,
                'Insumo_id' => 15,
                'Cantidad' => $request->Ins15,
                'Estatus' => 0,
            ]);
        }if(isset($request->Ins16)){

        }if(isset($request->Ins17)){

        }if(isset($request->Ins18)){

        }if(isset($request->Ins19)){

        }if(isset($request->Ins20)){

        }if(isset($request->Ins21)){

        }if(isset($request->Ins22)){

        }if(isset($request->Ins23)){

        }if(isset($request->Ins24)){

        }if(isset($request->Ins25)){

        }if(isset($request->Ins26)){

        }if(isset($request->Ins27)){

        }if(isset($request->Ins28)){

        }if(isset($request->Ins29)){

        }if(isset($request->Ins30)){

        }if(isset($request->Ins31)){

        }if(isset($request->Ins32)){

        }if(isset($request->Ins33)){

        }if(isset($request->Ins34)){

        }if(isset($request->Ins35)){

        }if(isset($request->Ins36)){

        }if(isset($request->Ins37)){

        }if(isset($request->Ins38)){

        }if(isset($request->Ins39)){

        }if(isset($request->Ins40)){

        }if(isset($request->Ins41)){

        }if(isset($request->Ins42)){

        }if(isset($request->Ins43)){

        }if(isset($request->Ins44)){

        }if(isset($request->Ins45)){

        }if(isset($request->Ins46)){

        }if(isset($request->Ins47)){

        }if(isset($request->Ins48)){

        }if(isset($request->Ins49)){

        }if(isset($request->Ins50)){

        }if(isset($request->Ins51)){

        }if(isset($request->Ins52)){

        }if(isset($request->Ins53)){

        }if(isset($request->Ins54)){

        }if(isset($request->Ins55)){

        }if(isset($request->Ins56)){

        }if(isset($request->Ins57)){

        }if(isset($request->Ins58)){

        }if(isset($request->Ins59)){

        }if(isset($request->Ins60)){

        }if(isset($request->Ins61)){

        }if(isset($request->Ins61)){

        }if(isset($request->Ins62)){

        }if(isset($request->Ins63)){

        }if(isset($request->Ins64)){

        }if(isset($request->Ins65)){

        }if(isset($request->Ins66)){

        }if(isset($request->Ins67)){

        }if(isset($request->Ins68)){

        }if(isset($request->Ins69)){

        }if(isset($request->Ins70)){

        }if(isset($request->Ins71)){

        }if(isset($request->Ins72)){

        }if(isset($request->Ins73)){

        }if(isset($request->Ins74)){

        }if(isset($request->Ins75)){

        }

        return redirect()->back();
    }
}
