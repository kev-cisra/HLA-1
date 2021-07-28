<?php

use App\Http\Controllers\Menus\MenuRecursosHumanosController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('', [MenuRecursosHumanosController::class,'index'])->name('RecursosHumanos');
