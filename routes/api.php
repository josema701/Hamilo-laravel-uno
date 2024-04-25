<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProveedorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/proveedores', [ProveedorController::class, 'index']);
Route::post('/proveedores', [ProveedorController::class, 'store']);
Route::get('/proveedores/{id}', [ProveedorController::class, 'show']);
Route::put('/proveedores/{id}', [ProveedorController::class, 'update']);
Route::delete('/proveedores/{id}', [ProveedorController::class, 'destroy']);
Route::get('/proveedores-activos', [ProveedorController::class, 'listarActivos']);
Route::post('/login', [AuthController::class, 'iniciarSesion']);
Route::group(["middleware" => "auth:sanctum"], function () {
    Route::post('/logout', [AuthController::class, 'cerrarSesion']);
});
