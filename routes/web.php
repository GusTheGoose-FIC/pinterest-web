<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\indexController;
use App\Http\Controllers\inicioController;




Route::get('/test', function () {
    return response()->json(['message' => 'API funcionando']);
});

Route::get('/homefeed', [indexController::class, 'index']);

Route::get('/', [inicioController::class, 'inicio']);

Route::get('/Información', [inicioController::class, 'Información'])->name('Información');

Route::get('/empresa', [inicioController::class, 'empresa'])->name('empresa');


