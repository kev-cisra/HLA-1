<?php


use App\Http\Controllers\Administrador\ModuloController;
use App\Http\Controllers\Administrador\Usuarios\UsersController;
use App\Http\Controllers\Menus\MenuAdminController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('', [MenuAdminController::class,'index'])->name('Admin');
Route::resource('Modulos', ModuloController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::resource('Usuarios', UsersController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('Usuarios');
