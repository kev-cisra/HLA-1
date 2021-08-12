<?php

namespace App\Http\Controllers\RecursosHumanos\Vacaciones;

use App\Http\Controllers\Controller;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Catalogos\JefesArea;
use App\Models\RecursosHumanos\Catalogos\Puestos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VacacionesDptoController extends Controller
{

    public function index(){
        $PerfilesUsuarios = PerfilesUsuarios::with('PerfilPuesto','PerfilDepartamento', 'PerfilJefe')->get();

        $Session = Auth::user();
        $Jefes = JefesArea::get(['id','Nombre']);
        $Puestos = Puestos::get(['id','Nombre']);
        $Departamentos = Departamentos::get(['id','Nombre']);

        //retorno de la vista retorno de la consulta de perfiles y sus filtros
        return Inertia::render('Hilaturas/Vacaciones', compact('PerfilesUsuarios', 'Jefes', 'Puestos', 'Departamentos', 'Session'));
    }

    public function create(){

    }

    public function store(Request $request){

    }

    public function show($id){

    }

    public function edit($id){

    }

    public function update(Request $request, $id){

    }

    public function destroy($id){

    }
}
