<?php

use App\Http\Controllers\Menus\MenuProducccionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('', [MenuProducccionController::class,'index'])->name('Produccion');
