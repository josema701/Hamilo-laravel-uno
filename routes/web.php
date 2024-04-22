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