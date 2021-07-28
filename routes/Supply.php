<?php

use App\Http\Controllers\Menus\MenuSupplyController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('', [MenuSupplyController::class,'index'])->name('Supply');
