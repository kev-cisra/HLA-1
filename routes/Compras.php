<?php

use App\Http\Controllers\Compras\Cotizaciones\CotizacionesController;
use App\Http\Controllers\Compras\Insumos\CatalogoInsumosController;
use App\Http\Controllers\Compras\Insumos\InsumosController;
use App\Http\Controllers\Compras\Insumos\InsumosRequisicionController;
use App\Http\Controllers\Compras\MarcasController;
use App\Http\Controllers\Compras\Papeleria\AltaMaterialPapeleriaController;
use App\Http\Controllers\Compras\Papeleria\RequisicionPapeleriaController;
use App\Http\Controllers\Compras\Papeleria\SolicitudesPapeleriaController;
use App\Http\Controllers\Compras\Proveedores\ProveedoresController;
use App\Http\Controllers\Compras\Requisiciones\MaquinasController;
use App\Http\Controllers\Compras\Requisiciones\RequisicionesController;
use App\Http\Controllers\Menus\MenuComprasController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//RUTA DEL MENU DE COMPRAS
Route::get('', [MenuComprasController::class,'index'])->name('Compras');

//RUTAS DE REQUISICIONES
Route::resource('Requisiciones', RequisicionesController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('Requisiciones');

Route::post('Requisiciones/RequisicionesMes', [RequisicionesController::class, 'RequisicionesMes'])
    ->middleware(['auth:sanctum', 'verified'])->name('RequisicionesMensual');

//RUTAS DE COTIZACIONES
Route::resource('Cotizaciones', CotizacionesController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('Cotizaciones');

    //Catalogos
    Route::get("/Maquinas", [MaquinasController::class, "Dropdown"]);

    Route::get("/Marcas", [MarcasController::class, "Dropdown"]);

Route::resource('Proveedores', ProveedoresController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('Proveedores');

Route::resource('RequisicionPapeleria', RequisicionPapeleriaController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('RequisicionPapeleria');

//Rutas de Papeleria
Route::resource('Papeleria', SolicitudesPapeleriaController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('Papeleria');

Route::resource('AltaPapeleria', AltaMaterialPapeleriaController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('AltaPapeleria');

//Rutas de Insumos
Route::resource('Insumos', InsumosController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('Insumos');

Route::resource('RequisicionesInsumos', InsumosRequisicionController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('RequisicionesInsumos');

    //Catalogos
    Route::get("/CatalogoInsumos", [CatalogoInsumosController::class, "Dropdown"]);
