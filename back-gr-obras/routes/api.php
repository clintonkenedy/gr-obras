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
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\UbigeoController;
use App\Http\Controllers\ValorizacionController;
use App\Http\Controllers\Api\V1\PermissionController as PermissionsControllerV1;
use App\Http\Controllers\Api\V1\RoleController as RoleControllerV1;
use App\Http\Controllers\Api\V1\UserController as UserControllerV1;
use App\Http\Controllers\AvanceMesController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('saludo', function () {
    return response()->json(['message' => 'Hola mundo']);
});


Route::apiResources([
    'v1/permisos' => PermissionsControllerV1::class,
]);
Route::apiResources([
    'v1/roles' => RoleControllerV1::class,
]);
Route::apiResources([
    'v1/usuarios' => UserControllerV1::class,
]);


//Ubigeo
Route::get('ubigeo', [UbigeoController::class, 'getUbigeo']);
Route::get('departamentos', [UbigeoController::class, 'getDepartamentos']);
Route::get('provincias', [UbigeoController::class, 'getProvincias']);
Route::get('distritos', [UbigeoController::class, 'getDistritos']);

Route::group(['prefix' => 'obras', 'middleware' => 'auth:api'], function () {
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('administrativo', AdministrativoController::class);
    Route::apiResource('archivo', ArchivoController::class);
    Route::apiResource('avance', AvanceController::class);
    Route::apiResource('avance_mes', AvanceMesController::class);
    Route::apiResource('cargo', CargoController::class);
    Route::apiResource('cronograma', CronogramaController::class);
    Route::apiResource('obra', ObraController::class);
    Route::apiResource('persona', PersonaController::class);
    Route::apiResource('presupuesto', PresupuestoController::class);
    Route::apiResource('profesion', ProfesionController::class);
    Route::apiResource('trabajador', TrabajadorController::class);
    Route::apiResource('valorizacion', ValorizacionController::class);
});
