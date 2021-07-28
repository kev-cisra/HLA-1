<?php

use App\Http\Controllers\Menus\MenuContabilidadController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('', [MenuContabilidadController::class,'index'])->name('Contabilidad');
