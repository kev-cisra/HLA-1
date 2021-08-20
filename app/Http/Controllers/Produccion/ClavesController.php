<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Produccion\catalogos\claves;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClavesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        Validator::make($request->all(), [
            'CVE_ART' => ['required','unique:claves'],
            'DESCR' => ['required']
        ])->validate();

        claves::create($request->all());

        return redirect()->back()
            ->with('message', 'Post Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produccion\catalogos\claves  $claves
     * @return \Illuminate\Http\Response
     */
    public function show(claves $claves)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produccion\catalogos\claves  $claves
     * @return \Illuminate\Http\Response
     */
    public function edit(claves $claves)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produccion\catalogos\claves  $claves
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, claves $claves)
    {
        //
        Validator::make($request->all(), [
            'CVE_ART' => ['required'],
            'DESCR' => ['required']
        ])->validate();

        if ($request->has('id')) {
            claves::find($request->input('id'))->update($request->all());
            return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produccion\catalogos\claves  $claves
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        //return 'algo';
        if ($request->has('id')) {
            claves::find($request->input('id'))->delete();
            return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
        }
    }
}
