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

// Rutas agrupadas por autenticación
// routes/web.php

Route::middleware(['auth'])->group(function () {
    Route::resource('ingresos', IngresoController::class);
    Route::resource('egresos', EgresoController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('metas', MetaController::class);

    // Rutas adicionales para las funcionalidades específicas de ingresos

    Route::post('ingresos/search', [IngresoController::class, 'search'])->name('ingresos.search');
    Route::post('ingresos/filter-by-date', [IngresoController::class, 'filterByDate'])->name('ingresos.filterByDate');
    // Route::get('/ingresos/summary', [IngresoController::class, 'index'])->name('ingresos.summary');

    Route::post('ingresos/bulk-delete', [IngresoController::class, 'bulkDelete'])->name('ingresos.bulk-delete');
    Route::post('ingresos/duplicate/{ingreso}', [IngresoController::class, 'duplicate'])->name('ingresos.duplicate');
});
