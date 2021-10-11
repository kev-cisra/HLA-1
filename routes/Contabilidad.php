<?php

use App\Http\Controllers\Contabilidad\Costos\CostosEmpaquesController;
use App\Http\Controllers\Menus\MenuContabilidadController;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('', [MenuContabilidadController::class,'index'])->name('Contabilidad');

Route::resource('CostosEmpaques', CostosEmpaquesController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('CostosEmpaques');
