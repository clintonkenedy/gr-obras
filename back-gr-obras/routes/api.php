<?php

use App\Http\Controllers\AdministrativoController;
use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\AvanceController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\CronogramaController;
use App\Http\Controllers\ObraController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\ProfesionController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\UbigeoController;
use App\Http\Controllers\ValorizacionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('saludo', function () {
    return response()->json(['message' => 'Hola mundo']);
});

Route::group(['prefix' => 'obras'], function () {
    Route::apiResource('administrativos', AdministrativoController::class);
    Route::apiResource('archivos', ArchivoController::class);
    Route::apiResource('avance', AvanceController::class);
    Route::apiResource('cargo', CargoController::class);
    Route::apiResource('cronograma', CronogramaController::class);
    Route::apiResource('obra', ObraController::class);
    Route::apiResource('persona', PersonaController::class);
    Route::apiResource('presupuesto', PresupuestoController::class);
    Route::apiResource('profesion', ProfesionController::class);
    Route::apiResource('trabajador', TrabajadorController::class);
    Route::apiResource('ubigeo', UbigeoController::class);
    Route::apiResource('valorizacion', ValorizacionController::class);
});
