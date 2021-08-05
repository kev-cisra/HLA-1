<?php

use App\Http\Controllers\Menus\MenuRecursosHumanosController;
use App\Http\Controllers\RecursosHumanos\PerfilesUsuarios\PerfilesUsuariosController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('', [MenuRecursosHumanosController::class,'index'])->name('RecursosHumanos');

Route::resource('PerfilesUsuarios', PerfilesUsuariosController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('PerfilesUsuarios');
