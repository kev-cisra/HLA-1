<?php

use App\Http\Controllers\Direccion\Calculadora\CalculadoraTorcionesController;
use App\Http\Controllers\Menus\MenuDireccionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('', [MenuDireccionController::class,'index'])->name('Direccion');

Route::resource('CalculadoraTorciones', CalculadoraTorcionesController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('CalculadoraTorciones');
