<?php

use App\Http\Controllers\Menus\MenuSistemasController;
use App\Http\Controllers\Sistemas\Mantenimientos\CalendarioController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('', [MenuSistemasController::class,'index'])->name('Sistemas');

Route::resource('CalendarioMantenimientos', CalendarioController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('CalendarioMantenimientos');
