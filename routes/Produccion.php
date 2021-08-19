<?php

use App\Http\Controllers\Menus\MenuAdminController;
use App\Http\Controllers\Menus\MenuProducccionController;
use App\Http\Controllers\Produccion\ClamatController;
use App\Http\Controllers\Produccion\MaquinasController;
use App\Http\Controllers\Produccion\MaterialesController;
use App\Http\Controllers\Produccion\PersonalController;
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

//Route::post('Procesos/carform', [ProcesosController::class,'carform']);

Route::resource('Personal', PersonalController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::resource('Procesos', ProcesosController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::resource('Maquinas', MaquinasController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::resource('Materiales', MaterialesController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::post('Clamat/claves', [ClamatController::class,'claves']);

Route::post('Clamat/destroyClaves', [ClamatController::class,'claves']);

Route::resource('Clamat', ClamatController::class)
    ->middleware(['auth:sanctum', 'verified']);


