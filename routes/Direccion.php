<?php

use App\Http\Controllers\Menus\MenuDireccionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('', [MenuDireccionController::class,'index'])->name('Direccion');
