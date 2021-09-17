<?php

use App\Http\Controllers\Menus\MenuSupplyController;
use App\Http\Controllers\Supply\Requisiciones\AutorizaRequisicionesController;
use App\Http\Controllers\Supply\Requisiciones\PresupuestosRequisicionesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('', [MenuSupplyController::class,'index'])->name('Supply');

Route::resource('AutorizaRequisiciones', AutorizaRequisicionesController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('AutorizaRequisiciones');

Route::resource('Presupuestos', PresupuestosRequisicionesController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('Presupuestos');
