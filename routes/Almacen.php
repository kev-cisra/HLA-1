<?php

use App\Http\Controllers\Almacen\Insumos\EntregaInsumosController;
use App\Http\Controllers\Almacen\Requisiciones\RequisicionesSolicitadasController;
use App\Http\Controllers\Menus\MenuAlmacenController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('', [MenuAlmacenController::class,'index'])->name('Almacen');

Route::resource('Requisiciones', RequisicionesSolicitadasController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('RequisicionesAlmacen');

Route::resource('EntregaInsumos', EntregaInsumosController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('EntregaInsumos');
