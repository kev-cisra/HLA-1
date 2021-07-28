<?php

use App\Http\Controllers\Menus\MenuComprasController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('', [MenuComprasController::class,'index'])->name('Compras');
