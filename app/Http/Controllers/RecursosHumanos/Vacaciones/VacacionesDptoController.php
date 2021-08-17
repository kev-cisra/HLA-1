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

        //Cosnulta para obtener el Numero de empleado de la session
        $Session = Auth::user();
        $SessionIdEmp = $Session->IdEmp;

        //Consulta pra obtener el id de Jefe de acuerdo al numero de empleado del trabajador
        $ObtenJefe = JefesArea::where('IdEmp', '=', $SessionIdEmp)->first('id','IdEmp');
        $IdJefe = $ObtenJefe->id; //Obtengo el id de trabajador de acuerdo al idEmpleado de la session

        //Consulta para obtener los datos de los trabajadores pertenecientes al id de la session
        $PerfilesUsuarios = PerfilesUsuarios::where('jefes_areas_id', '=', $IdJefe)
        ->with([
            'PerfilPuesto' => function($puesto) { //Relacion 1 a 1 De puestos
                $puesto->select('id', 'Nombre');
            },
            'PerfilDepartamento' => function($departamento) { //Relacion 1 a 1 De Departamento
                $departamento->select('id', 'Nombre');
            },
            'PerfilJefe' => function($jefe) { //Relacion 1 a 1 De Jefe
                $jefe->select('id', 'IdEmp',  'Nombre');
                // $jefe->where('IdEmp', '=', 5310);
            }
        ])
        ->get(['IdEmp', 'Nombre', 'ApPat', 'ApMat', 'DiasVac', 'Departamento_id', 'Puesto_id', 'jefes_areas_id', 'Empresa']); //datos de Perfiles


        //Catalogos
        $Jefes = JefesArea::get(['id','Nombre']);
        $Puestos = Puestos::get(['id','Nombre']);
        $Departamentos = Departamentos::get(['id','Nombre']);

        //retorno de la vista retorno de la consulta de perfiles y sus filtros
        return Inertia::render('Hilaturas/Vacaciones', compact('PerfilesUsuarios', 'Session'));
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
