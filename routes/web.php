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

});
