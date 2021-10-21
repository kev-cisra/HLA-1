<?php

use App\Http\Controllers\Menus\HilaturasController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('', [HilaturasController::class,'index'])->name('Hilaturas');


