<?php

use App\Http\Controllers\Menus\MenuProducccionController;
use App\Http\Controllers\Produccion\ProcesosController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*Route::middleware(['auth:sanctum', 'verified'])->get('', function(){
    return Inertia::render('Produccion/index');
})->name('Produccion');
*/
Route::get('', [MenuProducccionController::class,'index'])->name('Produccion');
//Redireccion y accion de procesos
Route::resource('Procesos', ProcesosController::class)
    ->middleware(['auth:sanctum', 'verified']);
