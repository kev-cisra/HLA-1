<?php

use App\Http\Controllers\Menus\MenuAdminController;
use App\Http\Controllers\Administrador\ModuloController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('', [MenuAdminController::class,'index'])->name('Admin');
//Route::get('Modulos', [ModuloController::class,'consu'])->name('Modulos');
Route::resource('Modulos', ModuloController::class)
    ->middleware(['auth:sanctum', 'verified']);
