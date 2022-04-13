<?php

namespace App\Http\Controllers\RecursosHumanos\Perfiles;

use App\Http\Controllers\Controller;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\JefeDepartamento;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JefeDepartamentoController extends Controller{

    protected $Dpto, $Per;

    public function __construct(Departamentos $Dpto, PerfilesUsuarios $Per){
        $this->Dpto = $Dpto;
        $this->Per = $Per;
    }

    public function index(){

        $Session = auth()->user();

        $Departamentos = $this->Dpto->SelectDepartamentos();

        $Perfiles = $this->Per->SelectPerfiles();

        $Jefes = JefeDepartamento::with('Perfil')->get();

        return Inertia::render('RecursosHumanos/PerfilesUsuarios/JefesDpto', compact('Session', 'Departamentos', 'Perfiles', 'Jefes'));
    }

    public function store(Request $request){
        JefeDepartamento::create($request->all());
        return redirect()->back();
    }

    public function update(Request $request, $id){


    }

    public function destroy($id){

    }
}
