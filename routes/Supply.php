<?php

use App\Http\Controllers\Menus\MenuSupplyController;
use App\Http\Controllers\Supply\Insumos\InsumosSolicitadosController;
use App\Http\Controllers\Supply\Requisiciones\AutorizaRequisicionesController;
use App\Http\Controllers\Supply\Requisiciones\GastosRequisiciones;
use App\Http\Controllers\Supply\Requisiciones\PresupuestosRequisicionesController;
use App\Http\Controllers\Supply\Sistemas\AutorizaRequisicionesSistemasController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('', [MenuSupplyController::class,'index'])->name('Supply');

Route::resource('AutorizaRequisiciones', AutorizaRequisicionesController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('AutorizaRequisiciones');

Route::resource('AutorizaReqSistemas', AutorizaRequisicionesSistemasController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('AutorizaReqSistemas');

Route::resource('Presupuestos', PresupuestosRequisicionesController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('Presupuestos');

Route::resource('GastosRequisiciones', GastosRequisiciones::class)
    ->middleware(['auth:sanctum', 'verified'])->names('GastosRequisiciones');

Route::resource('InsumosSolicitados', InsumosSolicitadosController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('InsumosSolicitados');
