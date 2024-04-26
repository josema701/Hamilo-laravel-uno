<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VentasController;
use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\ComprasController;
use App\Http\Controllers\Api\ProductosController;
use App\Http\Controllers\Api\ProveedorController;

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

    // API PRODUCTOS
    Route::get('/productos', [ProductosController::class, 'index']);
    Route::post('/productos', [ProductosController::class, 'store']);
    Route::get('/productos/{id}', [ProductosController::class, 'show']);
    Route::put('/productos/{id}', [ProductosController::class, 'update']);
    Route::delete('/productos/{id}', [ProductosController::class, 'destroy']);
    Route::get('/productos-activos', [ProductosController::class, 'listarActivos']);

    // API CLIENTES
    Route::get('/clientes', [ClienteController::class, 'index']);
    Route::post('/clientes', [ClienteController::class, 'store']);
    Route::get('/clientes/{id}', [ClienteController::class, 'show']);
    Route::put('/clientes/{id}', [ClienteController::class, 'update']);
    Route::delete('/clientes/{id}', [ClienteController::class, 'destroy']);
    Route::get('/clientes-activos', [ClienteController::class, 'listarActivos']);

    // API COMPRAS
    Route::get('/compras', [ComprasController::class, 'index']);
    Route::post('/compras', [ComprasController::class, 'store']);
    Route::get('/compras/{id}', [ComprasController::class, 'show']);
    Route::delete('/compras/{id}', [ComprasController::class, 'destroy']);

    // API VENTAS
    Route::get('/ventas', [VentasController::class, 'index']);
    Route::post('/ventas', [VentasController::class, 'store']);
    Route::get('/ventas/{id}', [VentasController::class, 'show']);
    Route::delete('/ventas/{id}', [VentasController::class, 'destroy']);
});
