<?php

namespace App\Http\Controllers\RecursosHumanos\Incidencias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Catalogos\JefesArea;
use App\Models\RecursosHumanos\Catalogos\Puestos;
use App\Models\RecursosHumanos\Incidencias\Incidencias;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Carbon\Carbon;
class IncidenciasDptoController extends Controller
{

    public function index(Request $request){

        $hoy= Carbon::now();
        $mes = $hoy->format('n');
        $anio = $hoy->format('Y');

        //Cosnulta para obtener el Numero de empleado de la session
        $Session = Auth::user();
        $SessionIdEmp = $Session->IdEmp;

        //Consulta pra obtener el id de Jefe de acuerdo al numero de empleado del trabajador
        $ObtenJefe = JefesArea::where('IdEmp', '=', $SessionIdEmp)->first('id','IdEmp');
        if(isset($ObtenJefe->id)){
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
            ->get(['id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat', 'DiasVac', 'Departamento_id', 'Puesto_id', 'jefes_areas_id', 'Empresa']); //datos de Perfiles
        }else{
            $PerfilesUsuarios = PerfilesUsuarios::with([
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
            ->get(['id', 'IdEmp', 'Nombre', 'ApPat', 'ApMat', 'DiasVac', 'Departamento_id', 'Puesto_id', 'jefes_areas_id', 'Empresa']); //datos de Perfiles
        }

        $Session = Auth::user();
        $Jefes = JefesArea::get(['id','Nombre']);
        $Puestos = Puestos::get(['id','Nombre']);
        $Departamentos = Departamentos::get(['id','Nombre']);

        $Session = Auth::user();

        if(!empty($request->busca)){
            $Incidencias = Incidencias::where('IdEmp', '=', $request->busca)
            ->whereYear('Fecha', '=', $anio)
            ->get(['id', 'IdUser', 'IdEmp', 'TipoMotivo', 'Fecha', 'FechaFin', 'Comentarios', 'perfiles_usuarios_id']);
        }else{
            $Incidencias = Incidencias::get(['id', 'IdUser', 'IdEmp', 'TipoMotivo', 'Fecha', 'FechaFin', 'Comentarios', 'perfiles_usuarios_id']);
        }

        return Inertia::render('RecursosHumanos/Incidencias/index', compact('PerfilesUsuarios', 'Jefes', 'Puestos', 'Departamentos', 'Session', 'Incidencias'));
    }

    public function create(){

    }

    public function store(Request $request){

        Validator::make($request->all(), [
            'Tipo' => ['required'],
            'Fecha' => ['required'],
            'Comentarios' => ['required'],
        ])->validate();

        Incidencias::create([
            'IdUser' => $request->IdUser,
            'IdEmp' => $request->IdEmp,
            'TipoMotivo' => $request->Tipo,
            'Fecha' => $request->Fecha,
            'FechaFin' => $request->FechaFin,
            'Comentarios' => $request->Comentarios,
            'perfiles_usuarios_id' => $request->id,
        ]);

        // return $request;

        return redirect()->back()->with('message', 'Exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
