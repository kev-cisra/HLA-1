<?php

use App\Http\Controllers\Menus\HilaturasController;
use App\Http\Controllers\RecursosHumanos\Vacaciones\VacacionesDptoController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('', [HilaturasController::class,'index'])->name('Hilaturas');

Route::resource('Vacaciones', VacacionesDptoController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('Vacaciones');
