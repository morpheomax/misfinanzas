<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EgresoController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\MetaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {

    // Route::get('/user', [UserController::class, 'index'])->name('user.index');
    // Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    // Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
    // Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
    Route::put('/user/{user}/password', [UserController::class, 'changePassword'])->name('user.changePassword');
    Route::put('/user/{user}/deactivate', [UserController::class, 'deactivate'])->name('user.deactivate');

    Route::resource('user', UserController::class);
    Route::resource('ingresos', IngresoController::class);
    Route::resource('egresos', EgresoController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('metas', MetaController::class);
    Route::resource('dashboard', DashboardController::class);

    // Ruta para obtener las categorías según el tipo
    Route::get('/categorias/{tipo}', [CategoriaController::class, 'getCategoriasPorTipo']);

    // Ruta para obtener los tipos que contienen la palabra 'Ingreso'
    Route::get('/api/tipo', [CategoriaController::class, 'getTiposIngreso']);
    // Ruta para obtener los tipos que contienen la palabra 'Ingreso'
    Route::get('/api/tipo/egreso', [CategoriaController::class, 'getTiposEgreso']);
// Ruta para obtener los nombres según el tipo seleccionado
    Route::get('/api/tipo/{tipo}/nombre', [CategoriaController::class, 'getNombresPorTipo']);
// Ruta para duplicar ingresos
    Route::post('/ingresos/{ingreso}/duplicate', [IngresoController::class, 'duplicate'])->name('ingresos.duplicate');
// Ruta para duplicar egresos
    Route::post('/egresos/{egreso}/duplicate', [EgresoController::class, 'duplicate'])->name('egresos.duplicate');

});
