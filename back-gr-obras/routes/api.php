<?php

use App\Models\Administrativo;
use App\Models\Archivo;
use App\Models\Avance;
use App\Models\Cargo;
use App\Models\Cronograma;
use App\Models\Obra;
use App\Models\Persona;
use App\Models\Presupuesto;
use App\Models\Profesion;
use App\Models\Trabajador;
use App\Models\Ubigeo;
use App\Models\Valorizacion;
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

Route::group(['prefix' => 'obras', 'middleware' => 'auth:api'], function () {
    Route::apiResource('administrativos', Administrativo::class);
    Route::apiResource('archivos', Archivo::class);
    Route::apiResource('avance', Avance::class);
    Route::apiResource('cargo', Cargo::class);
    Route::apiResource('cronograma', Cronograma::class);
    Route::apiResource('obra', Obra::class);
    Route::apiResource('persona', Persona::class);
    Route::apiResource('presupuesto', Presupuesto::class);
    Route::apiResource('profesion', Profesion::class);
    Route::apiResource('trabajador', Trabajador::class);
    Route::apiResource('ubigeo', Ubigeo::class);
    Route::apiResource('valorizacion', Valorizacion::class);
});
