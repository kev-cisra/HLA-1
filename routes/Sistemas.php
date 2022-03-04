<?php

use App\Http\Controllers\Menus\MenuSistemasController;
use App\Http\Controllers\Sistemas\Equipos\EquiposAsignadosController;
use App\Http\Controllers\Sistemas\Equipos\EquiposComputoController;
use App\Http\Controllers\Sistemas\Mantenimientos\CalendarioController;
use App\Http\Controllers\Sistemas\Requisiciones\CotizacionesSistemasController;
use App\Http\Controllers\Sistemas\Requisiciones\RequisicionesSistemasController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('', [MenuSistemasController::class,'index'])->name('Sistemas');

Route::resource('EquiposComputo', EquiposComputoController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('EquiposComputo');

Route::resource('EquiposComputoAsignado', EquiposAsignadosController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('EquiposComputoAsignado');

Route::resource('CalendarioMantenimientos', CalendarioController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('CalendarioMantenimientos');

Route::resource('RequisicionSistemas', RequisicionesSistemasController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('RequisicionSistemas');

Route::resource('CotizacionSistemas', CotizacionesSistemasController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('CotizacionSistemas');
