<?php

use App\Http\Controllers\Menus\MenuCalidadController;
use App\Http\Controllers\Produccion\General\GeneralController;
use Illuminate\Support\Facades\Route;

Route::get('', [MenuCalidadController::class,'index'])->name('Calidad');

/************************************** Consultas Generales ****************************************************/
//Abastos
Route::post('ConAbast', [GeneralController::class, 'ConAbast'])->name('ConAbastosGe')
    ->middleware(['auth:sanctum', 'verified']);

//departamento
Route::post('ConDepa', [GeneralController::class, 'ConDepa'])->name('ConDepartamento')
    ->middleware(['auth:sanctum', 'verified']);

/************************* carga de procesos *************************/
Route::post('CaliPro', [MenuCalidadController::class, 'store'])->name('CaliProceso')
    ->middleware(['auth:sanctum', 'verified']);

Route::post('ConProCali', [MenuCalidadController::class, 'ConProCali'])->name('ConProCali')
    ->middleware(['auth:sanctum', 'verified']);
