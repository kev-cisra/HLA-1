<?php

use App\Http\Controllers\Produccion\ExcelImport\CargarExcelController;
use App\Http\Controllers\Menus\MenuProducccionController;
use App\Http\Controllers\Produccion\Calculos\CalculosController;
use App\Http\Controllers\Produccion\CargaController;
use App\Http\Controllers\Produccion\CarNormController;
use App\Http\Controllers\Produccion\CarOpeController;
use App\Http\Controllers\Produccion\ClamatController;
use App\Http\Controllers\Produccion\ClavesController;
use App\Http\Controllers\Produccion\EntregasController;
use App\Http\Controllers\Produccion\EquiposController;
use App\Http\Controllers\Produccion\General\GeneralController;
use App\Http\Controllers\Produccion\MaquinasController;
use App\Http\Controllers\Produccion\MaterialesController;
use App\Http\Controllers\Produccion\notascargaController;
use App\Http\Controllers\Produccion\ObjeCordiController;
use App\Http\Controllers\Produccion\ParosController;
use App\Http\Controllers\Produccion\PersonalController;
use App\Http\Controllers\Produccion\ProcesosController;
use App\Http\Controllers\Produccion\RepoProController;
use App\Http\Controllers\Produccion\TurnosController;
use Illuminate\Support\Facades\Route;

/*Route::middleware(['auth:sanctum', 'verified'])->get('', function(){
    return Inertia::render('Produccion/index');
})->name('Produccion');
*/
Route::get('', [MenuProducccionController::class,'index'])->name('Produccion');
//Redireccion y accion de procesos

//Route::post('Procesos/carform', [ProcesosController::class,'carform']);

/************************************** Consultas Generales ****************************************************/
//maquinas
Route::post('General/ConMaquina', [GeneralController::class, 'ConMaqui'])->name('GConMaqui')
->middleware(['auth:sanctum', 'verified']);
//procesos
Route::post('General/ConProduccion', [GeneralController::class, 'ConProdu'])->name('GConProdu')
->middleware(['auth:sanctum', 'verified']);
//materiales
Route::post('General/ConMateriales', [GeneralController::class, 'ConMate'])->name('GConMate')
->middleware(['auth:sanctum', 'verified']);
//turnos
Route::post('General/ConTurno', [GeneralController::class, 'ConTurno'])->name('ConsuTurno')
->middleware(['auth:sanctum', 'verified']);
//personal
Route::post('General/ConPerso', [GeneralController::class, 'ConPerso'])->name('ConPersonal')
->middleware(['auth:sanctum', 'verified']);
/************************************** Fin de consultas generales ********************************************/

Route::resource('Personal', PersonalController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::resource('Procesos', ProcesosController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::resource('Maquinas', MaquinasController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::resource('Materiales', MaterialesController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::resource('Claves', ClavesController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::resource('Clamat', ClamatController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::resource('Turnos', TurnosController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::resource('Equipos', EquiposController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::resource('Carga', CargaController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::resource('Nota', notascargaController::class)
    ->middleware(['auth:sanctum', 'verified']);

//Modulo de paros
Route::resource('Paros', ParosController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::post('Paros/ParCar', [ParosController::class, 'ParoCarga'])->name('ParoCarga');

//fin modulo paros

Route::resource('Entregas', EntregasController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::resource('Calcula', CalculosController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::resource('CarOpe', CarOpeController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::resource('CarNor', CarNormController::class)
    ->middleware(['auth:sanctum', 'verified']);

//Reportes de produccion
Route::resource('ReportesPro', RepoProController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::post('ReportesPro/ConPro', [RepoProController::class, 'ConProdu'])->name('ConPro')
->middleware(['auth:sanctum', 'verified']);

Route::post('ReportesPro/ConParo', [RepoProController::class, 'ConParo'])->name('ConParo')
->middleware(['auth:sanctum', 'verified']);

Route::post('ReportesPro/ConGrafi', [RepoProController::class, 'ConGrafi'])->name('ConGraficas')
->middleware(['auth:sanctum', 'verified']);

Route::post('ReportesPro/ElimiGra', [RepoProController::class, 'ElimiGra'])->name('ElimiGraficas')
->middleware(['auth:sanctum', 'verified']);

Route::post('ReportesPro/PaiGrafi', [RepoProController::class, 'PaiGrafi'])->name('PaiGrafica')
->middleware(['auth:sanctum', 'verified']);
Route::post('ReportesPro/PrPaiGrafi', [RepoProController::class, 'PrPaiGrafi'])->name('PrPaiGrafica')
->middleware(['auth:sanctum', 'verified']);
Route::post('ReportesPro/PaiGrafiRan', [RepoProController::class, 'PaiGrafiRan'])->name('PaiGraficaRan')
->middleware(['auth:sanctum', 'verified']);

Route::post('ReportesPro/LinGrafi', [RepoProController::class, 'LinGrafi'])->name('LinGrafica')
->middleware(['auth:sanctum', 'verified']);

Route::post('ReportesPro/SaveGra', [RepoProController::class, 'SaveGrafi'])->name('SaveGrafica')
->middleware(['auth:sanctum', 'verified']);

Route::post('ReportesPro/UpdateGrafi', [RepoProController::class, 'UpdateGrafi'])->name('UpdateGrafica')
->middleware(['auth:sanctum', 'verified']);

//Fin de reporte de rpoduccion

//Carga de produccion y objetivos
Route::post('Carga/CarProdu', [CargaController::class, 'CarProdu'])->name('CarProduccion')
->middleware(['auth:sanctum', 'verified']);

Route::post('Carga/CarNorma', [CargaController::class, 'CarNorma'])->name('CargaNorma')
->middleware(['auth:sanctum', 'verified']);

Route::post('Carga/CarOperador', [CargaController::class, 'CarOperador'])->name('CargaOperador')
->middleware(['auth:sanctum', 'verified']);

Route::post('Carga/CarObje', [CargaController::class, 'CarObje'])->name('CarObjetivo')
->middleware(['auth:sanctum', 'verified']);

//Fin carga de produccion y objetivos

Route::resource('CargaExcel', CargarExcelController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::resource('ObjeCordi', ObjeCordiController::class)
    ->middleware(['auth:sanctum', 'verified']);
