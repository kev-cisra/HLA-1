<?php

namespace App\Http\Controllers\RecursosHumanos\Vacaciones;

use App\Http\Controllers\Controller;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use App\Models\RecursosHumanos\Vacaciones\Vacaciones;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class ReporteVacacionesController extends Controller{

    public function index(Request $request){
        $Session = Auth::user();

        if($request->ini == '' && $request->fin == ''){
            $Vacaciones = PerfilesUsuarios::select(
                'perfiles_usuarios.id AS PerfilId',
                'perfiles_usuarios.IdEmp AS IdEmp',
                'perfiles_usuarios.Nombre AS Nombre',
                'perfiles_usuarios.ApPat AS ApPat',
                'perfiles_usuarios.ApMat AS ApMat',
                'perfiles_usuarios.DiasVac AS DiasVac',
                'puestos.Nombre AS Puesto',
                'perfiles_usuarios.Empresa AS Empresa',
                'vacaciones.FechaInicio AS FechaInicio',
                'vacaciones.FechaFin AS FechaFin',
                'vacaciones.Comentarios AS Comentarios',
                'vacaciones.DiasTomados AS DiasTomados',
                'vacaciones.DiasRestantes AS DiasRestantes',
                'vacaciones.Perfil_id AS Perfil_id')
                ->join('puestos', 'perfiles_usuarios.Puesto_id', '=', 'puestos.id')
                ->join('vacaciones', 'perfiles_usuarios.id', '=', 'vacaciones.Perfil_id')
                ->get();
        }else{
            $Vacaciones = PerfilesUsuarios::select(
                'perfiles_usuarios.IdEmp AS IdEmp',
                'perfiles_usuarios.Nombre AS Nombre',
                'perfiles_usuarios.ApPat AS ApPat',
                'perfiles_usuarios.ApMat AS ApMat',
                'perfiles_usuarios.DiasVac AS DiasVac',
                'puestos.Nombre AS Puesto',
                'perfiles_usuarios.Empresa AS Empresa',
                'vacaciones.FechaInicio AS FechaInicio',
                'vacaciones.FechaFin AS FechaFin',
                'vacaciones.Comentarios AS Comentarios',
                'vacaciones.DiasTomados AS DiasTomados',
                'vacaciones.DiasRestantes AS DiasRestantes')
                ->join('puestos', 'perfiles_usuarios.Puesto_id', '=', 'puestos.id')
                ->join('vacaciones', 'perfiles_usuarios.IdEmp', '=', 'vacaciones.IdEmp')
                ->whereBetween('vacaciones.FechaInicio', [$request->ini, $request->fin])
                ->get();
        }

        return Inertia::render('RecursosHumanos/ReporteVacaciones/index', compact('Session','Vacaciones'));
    }

    public function store(Request $request){

        $user = User::get();
        header("Content-type:application/pdf");
        $pdfContent = PDF::loadView('RecursosHumanos/ReporteVacaciones')->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "ReporteVacaciones.pdf"
        );

        // return view('RecursosHumanos/ReporteVacaciones', compact('user'));
    }

    public function show($id){

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
