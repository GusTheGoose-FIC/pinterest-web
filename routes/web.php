<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\indexController;
use App\Http\Controllers\inicioController;




Route::get('/test', function () {
    return response()->json(['message' => 'API funcionando']);
});

Route::get('/homefeed', [indexController::class, 'index']);

Route::get('/', [inicioController::class, 'inicio']);

Route::get('/incio', [inicioController::class, 'inicio'])->name('inicio');

Route::get('/Información', [inicioController::class, 'Información'])->name('Información');

Route::get('/empresa', [inicioController::class, 'empresa'])->name('empresa');

Route::get('/Create', [inicioController::class, 'Create'])->name('Create');

Route::get('/News', [inicioController::class, 'News'])->name('News');

Route::get('/Login', [inicioController::class, 'Login'])->name('Login');

Route::get('/registro', [RegisteredUserController::class, 'registro'])->name('registro');

Route::get('/Condiciones', [inicioController::class, 'Condiciones'])->name('Condiciones');

Route::get('/PoliticasPrivacidad', [inicioController::class, 'PoliticasPrivacidad'])->name('PoliticasPrivacidad');

Route::get('/Comunidad', [inicioController::class, 'Comunidad'])->name('Comunidad');

Route::get('/propiedadIntelectual', [inicioController::class, 'propiedadIntelectual'])->name('propiedadIntelectual');

Route::get('/marcaComercial', [inicioController::class, 'marcaComercial'])->name('marcaComercial');

Route::get('/Transparencia', [inicioController::class, 'Transparencia'])->name('Transparencia');

Route::get('/Mas', [inicioController::class, 'Mas'])->name('Mas');

Route::get('/Ayuda', [inicioController::class, 'Ayuda'])->name('Ayuda');

Route::get('/AvisosnoUsuario', [inicioController::class, 'AvisosnoUsuarios'])->name('AvisosnoUsuario');
Route::get('/Liderazgo', [inicioController::class, 'Liderazgo'])->name('Liderazgo');

require __DIR__.'/auth.php';