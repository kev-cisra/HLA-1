<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth:sanctum', 'verified'])->get('/Produccion', function(){
    return Inertia::render('Produccion/index');
})->name('Produccion');
