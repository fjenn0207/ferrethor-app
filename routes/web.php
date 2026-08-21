<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ProveedorController;

// Página Principal / Dashboard de Bienvenida
Route::get('/', function () {
    return view('welcome');
});

// Rutas de Proveedores y Historial
Route::get('/proveedores/crear', [ProveedorController::class, 'create'])->name('proveedores.create');
Route::get('/facturas/historial', [FacturaController::class, 'historial'])->name('facturas.historial');
Route::post('/proveedores', [ProveedorController::class, 'store'])->name('proveedores.store');

// Rutas de Facturas manejadas mediante Resource
Route::resource('facturas', FacturaController::class);
Route::resource('proveedores', ProveedorController::class);

// Rutas personalizadas para acciones en Facturas
Route::patch('/facturas/{id}/pagar', [FacturaController::class, 'pagar'])->name('facturas.pagar');
Route::patch('/facturas/{id}/complemento', [FacturaController::class, 'guardarComplemento'])->name('facturas.complemento');
Route::patch('/facturas/{id}/restaurar', [FacturaController::class, 'restaurar'])->name('facturas.restaurar');
Route::delete('/facturas/{id}/eliminar-definitivo', [FacturaController::class, 'forceDelete'])->name('facturas.forceDelete');