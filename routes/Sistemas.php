<?php

use App\Http\Controllers\Menus\MenuSistemasController;
use App\Http\Controllers\Sistemas\Hardware\EquiposAsignadosController;
use App\Http\Controllers\Sistemas\Hardware\HardwareSistemasController;
use App\Http\Controllers\Sistemas\Mantenimientos\CalendarioController;
use App\Http\Controllers\Sistemas\Mantenimientos\MantenimientosSistemasController;
use App\Http\Controllers\Sistemas\Requisiciones\CotizacionesSistemasController;
use App\Http\Controllers\Sistemas\Requisiciones\ProveedoresController;
use App\Http\Controllers\Sistemas\Requisiciones\RequisicionesSistemasController;
use App\Models\Sistemas\Hardware\HardwareSistemas;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('', [MenuSistemasController::class,'index'])->name('Sistemas');

Route::resource('EquiposComputo', HardwareSistemasController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('EquiposComputo');

Route::resource('EquiposAsignados', EquiposAsignadosController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('EquiposAsignados');

Route::resource('CalendarioMantenimientos', MantenimientosSistemasController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('CalendarioMantenimientos');

    Route::post('CalendarioMantenimientos/Eventos', [CalendarioController::class, 'Eventos'])->name('Eventos')
    ->middleware(['auth:sanctum', 'verified']);

Route::resource('RequisicionSistemas', RequisicionesSistemasController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('RequisicionSistemas');

Route::resource('CotizacionSistemas', CotizacionesSistemasController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('CotizacionSistemas');

Route::resource('Proveedores', ProveedoresController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('Proveedores');
