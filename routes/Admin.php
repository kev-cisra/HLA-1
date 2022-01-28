<?php

use App\Http\Controllers\Administrador\ModuloController;
use App\Http\Controllers\Administrador\Panel\AdminPanelController;
use App\Http\Controllers\Administrador\Roles\RolesUsuariosController;
use App\Http\Controllers\Administrador\Roles\UserController;
use App\Http\Controllers\Administrador\Usuarios\UsersController;
use App\Http\Controllers\Menus\MenuAdminController;
use App\Mail\ContactaProveedorMailable;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('', [MenuAdminController::class,'index'])->name('Admin');

Route::resource('Modulos', ModuloController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::resource('Usuarios', UsersController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('Usuarios');

Route::resource('RolesUsuarios', RolesUsuariosController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('RolesUsuarios');

Route::resource('AdminPanel', AdminPanelController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('AdminPanel');

Route::resource('users', UserController::class)->only(['index', 'edit', 'update'])->names('admin.users');

