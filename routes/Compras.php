<?php

use App\Http\Controllers\Compras\Cotizaciones\CotizacionesController;
use App\Http\Controllers\Compras\MarcasController;
use App\Http\Controllers\Compras\Proveedores\ProveedoresController;
use App\Http\Controllers\Compras\Requisiciones\RequisicionesController;
use App\Http\Controllers\Menus\MenuComprasController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('', [MenuComprasController::class,'index'])->name('Compras');

Route::resource('Requisiciones', RequisicionesController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('Requisiciones');

Route::resource('Cotizaciones', CotizacionesController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('Cotizaciones');

Route::resource('Proveedores', ProveedoresController::class)
    ->middleware(['auth:sanctum', 'verified'])->names('Proveedores');

Route::get("/Marcas", [MarcasController::class, "Dropdown"]);
