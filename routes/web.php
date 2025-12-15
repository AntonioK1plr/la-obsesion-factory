<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\HistorialController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Rutas para recursos (CRUD)
Route::resource('productos', ProductoController::class);
Route::resource('servicios', ServicioController::class);
Route::resource('clientes', ClienteController::class);
Route::resource('compras', CompraController::class);
Route::resource('ventas', VentaController::class);

// Rutas para historial
Route::get('/historial/compras', [HistorialController::class, 'compras'])->name('historial.compras');
Route::get('/historial/ventas', [HistorialController::class, 'ventas'])->name('historial.ventas');
