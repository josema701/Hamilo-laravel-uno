<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/productos', [App\Http\Controllers\ProductosController::class, 'index']);
    // /productos/registrar
    Route::get('/productos/registrar', [App\Http\Controllers\ProductosController::class, 'create'])->name('productos.create');
    Route::post('/productos/registrar', [App\Http\Controllers\ProductosController::class, 'store'])->name('productos.store');
    // /productos/actualizar/ id
    Route::get('/productos/actualizar/{id}', [App\Http\Controllers\ProductosController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/actualizar/{id}', [App\Http\Controllers\ProductosController::class, 'update'])->name('productos.update');
    // cambiar estado
    Route::get('/productos/estado/{id}', [App\Http\Controllers\ProductosController::class, 'cambiarEstado'])->name('productos.estado');
    //PROVEEDORES
    Route::get('/proveedores', [App\Http\Controllers\ProveedorController::class, 'index']);
    Route::get('/proveedores/registrar', [App\Http\Controllers\ProveedorController::class, 'create']);
    Route::post('/proveedores', [App\Http\Controllers\ProveedorController::class, 'store']);
    Route::delete('/proveedores/{id}', [App\Http\Controllers\ProveedorController::class, 'eliminar']);
    // /proveedores/actualizar/{id}
    Route::get('/proveedores/actualizar/{id}', [App\Http\Controllers\ProveedorController::class, 'edit']);
    Route::put('/proveedores/actualizar/{id}', [App\Http\Controllers\ProveedorController::class, 'update']);
    Route::get('/proveedores/estado/{id}', [App\Http\Controllers\ProveedorController::class, 'cambiarEstado']);

    // CLIENTES 
    Route::get('/clientes', [App\Http\Controllers\ClienteController::class, 'index']);
    Route::get('/clientes/registrar', [App\Http\Controllers\ClienteController::class, 'create']);
    Route::post('/clientes', [App\Http\Controllers\ClienteController::class, 'store']);
    Route::get('/clientes/actualizar/{id}', [App\Http\Controllers\ClienteController::class, 'edit']);
    Route::put('/clientes/{id}', [App\Http\Controllers\ClienteController::class, 'update']);
    Route::get('/clientes/estado/{id}', [App\Http\Controllers\ClienteController::class, 'cambiarEstado']);

    //COMPRAS 
    Route::get('/compras', [App\Http\Controllers\ComprasController::class, 'index']);
    Route::get('/compras/registrar', [App\Http\Controllers\ComprasDetalleTemporalController::class, 'create']);
    Route::get('/compras/add-carrito/{id}', [App\Http\Controllers\ComprasDetalleTemporalController::class, 'carrito']);
    Route::get('/compras/remove-carrito/{id}', [App\Http\Controllers\ComprasDetalleTemporalController::class, 'removeCarrito']);
    Route::get('/compras/incrementar-carrito/{id}', [App\Http\Controllers\ComprasDetalleTemporalController::class, 'addCantidad']);
    Route::get('/compras/decrementar-carrito/{id}', [App\Http\Controllers\ComprasDetalleTemporalController::class, 'restarCantidad']);
    Route::post('/compras/guardar', [App\Http\Controllers\ComprasDetalleTemporalController::class, 'terminarCompra']);
    Route::get('/compras/{id}', [App\Http\Controllers\ComprasController::class, 'show']);
    Route::get('/compras/estado/{id}', [App\Http\Controllers\ComprasController::class, 'estado']);

    //VENTAS
    Route::get('/ventas', [App\Http\Controllers\VentasController::class, 'index']);
    Route::get('/ventas/registrar', [App\Http\Controllers\VentasDetalleTemporalController::class, 'create']);
    Route::get('/ventas/add-carrito/{id}', [App\Http\Controllers\VentasDetalleTemporalController::class, 'carrito']);
    Route::get('/ventas/incrementar-carrito/{id}', [App\Http\Controllers\VentasDetalleTemporalController::class, 'addCantidad']);
    Route::get('/ventas/decrementar-carrito/{id}', [App\Http\Controllers\VentasDetalleTemporalController::class, 'restarCantidad']);
    Route::get('/ventas/remove-carrito/{id}', [App\Http\Controllers\VentasDetalleTemporalController::class, 'removeCarrito']);
    Route::post('/ventas/guardar', [App\Http\Controllers\VentasDetalleTemporalController::class, 'terminarVenta']);
});
