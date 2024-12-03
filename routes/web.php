<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EgresoController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\MetaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::resource('ingresos', IngresoController::class);
    Route::resource('egresos', EgresoController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('metas', MetaController::class);

    // Ruta para obtener las categorías según el tipo
    Route::get('/categorias/{tipo}', [CategoriaController::class, 'getCategoriasPorTipo']);

    // Ruta para obtener los tipos que contienen la palabra 'Ingreso'
    Route::get('/api/tipo', [CategoriaController::class, 'getTiposIngreso']);
    // Ruta para obtener los tipos que contienen la palabra 'Ingreso'
    Route::get('/api/tipo/egreso', [CategoriaController::class, 'getTiposEgreso']);
// Ruta para obtener los nombres según el tipo seleccionado
    Route::get('/api/tipo/{tipo}/nombre', [CategoriaController::class, 'getNombresPorTipo']);

});
