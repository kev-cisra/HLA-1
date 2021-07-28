<?php

use App\Http\Controllers\Menus\MenuSistemasController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('', [MenuSistemasController::class,'index'])->name('Sistemas');
