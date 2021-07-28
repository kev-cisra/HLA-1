<?php

use App\Http\Controllers\Menus\MenuAdminController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('', [MenuAdminController::class,'index'])->name('Admin');
