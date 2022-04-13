<?php

namespace App\Http\Controllers\RecursosHumanos\Incidencias;

use App\Http\Controllers\Controller;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Incidencias\Incidencias;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class ReporteIncidenciasController extends Controller
{

    public function index(Request $request){
        $Session = Auth::user();
        $Departamentos = Departamentos::get(['id','Nombre']);

        if($request->ini != '' || $request->ini != ''){
            $Incidencias = Incidencias::with('IncidenciaPerfil')->whereBetween('Fecha', [$request->ini, $request->fin])->get();
        }else{
            $Incidencias = Incidencias::with('IncidenciaPerfil')->get();
        }


        //Consulta para obtener los datos de los trabajadores pertenecientes al id de la session
        // $PerfilesUsuarios = PerfilesUsuarios::with('PerfilIncidencias')->get(); //datos de Perfiles

        return Inertia::render('RecursosHumanos/ReporteIncidencias/index', compact('Session', 'Incidencias', 'Departamentos'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
