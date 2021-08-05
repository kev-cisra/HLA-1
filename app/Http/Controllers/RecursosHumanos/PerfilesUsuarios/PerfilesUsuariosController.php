<?php

namespace App\Http\Controllers\RecursosHumanos\PerfilesUsuarios;

use App\Http\Controllers\Controller;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PerfilesUsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Validacion de datos por URl (evitar ataques OWASP)
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:id,name,email']
        ]);

        //constructor de consultas
        $query = PerfilesUsuarios::query();

        //si detecta un valor en request->search realiza la consulta
        if(request('search')){
            $query->where(request('column'), 'LIKE', '%'.request('search'). '%');
        }

        //si detecta un valor en request->field realiza la consulta
        if(request()->has(['field', 'direction'])){
            $query->orderBy(request('field'), request('direction'));
        }

        $PerfilesPuesto = PerfilesUsuarios::with('PerfilPuesto','PerfilDepartamento', 'PerfilJefe')->get();

        //retorno de la vista retorno de la consulta de perfiles y sus filtros
        return Inertia::render('RecursosHumanos/PerfilesUsuarios/index', [
            'PerfilesPuesto' => $PerfilesPuesto,
            'Perfiles' => $query->paginate(request('paginate')),
            'filters' => request()->all(['search','field', 'direction'])
        ]);
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
