<?php

use App\Http\Controllers\Menus\MenuRecursosHumanosController;
use App\Http\Controllers\RecursosHumanos\Incidencias\IncidenciasController;
use App\Http\Controllers\RecursosHumanos\Incidencias\IncidenciasDptoController;
use App\Http\Controllers\RecursosHumanos\Incidencias\ReporteIncidenciasController;
use App\Http\Controllers\RecursosHumanos\PerfilesUsuarios\PerfilesUsuariosController;
use App\Http\Controllers\RecursosHumanos\Vacaciones\ReporteVacacionesController;
use App\Http\Controllers\RecursosHumanos\Vacaciones\VacacionesDptoController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('', [MenuRecursosHumanosController::class,'index'])->name('RecursosHumanos');

Route::resource('PerfilesUsuarios', PerfilesUsuariosController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('PerfilesUsuarios');

Route::resource('Vacaciones', VacacionesDptoController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('Vacaciones');

Route::resource('Incidencias', IncidenciasDptoController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('Incidencias');

Route::resource('ReporteVacaciones', ReporteVacacionesController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('ReporteVacaciones');

Route::resource('ReporteIncidencias', ReporteIncidenciasController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('ReporteIncidencias');
