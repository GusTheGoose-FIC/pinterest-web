<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\indexController;
use App\Http\Controllers\inicioController;
use App\Http\Controllers\userController;

use function PHPUnit\Framework\returnSelf;

Route::get('/test', function () {
    return response()->json(['message' => 'API funcionando']);
});

Route::get('/homefeed', [indexController::class, 'index']);

Route::get('/', [inicioController::class, 'inicio']);

Route::get('/Información', [inicioController::class, 'Información'])->name('Información');

Route::get('/empresa', [inicioController::class, 'empresa'])->name('empresa');

Route::get('/Create', [inicioController::class, 'Create'])->name('Create');

Route::get('/News', [inicioController::class, 'News'])->name('News');

Route::get('/Login', [inicioController::class, 'Login'])->name('Login');


