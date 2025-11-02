<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\indexController;
use App\Http\Controllers\inicioController;
use App\Http\Controllers\ImageController;

// Rutas para manejo de imágenes
Route::middleware(['auth'])->group(function () {
    Route::post('/images', [ImageController::class, 'store'])->name('images.store');
    Route::get('/images/{image}', [ImageController::class, 'show'])->name('images.show');
    Route::delete('/images/{image}', [ImageController::class, 'destroy'])->name('images.destroy');
    Route::get('/ideas/{idea}/images', [ImageController::class, 'getByIdea'])->name('ideas.images');
});



Route::get('/test-mongo', function () {
    try {
        $dbs = DB::connection('mongodb')->getMongoClient()->listDatabases();
        return '✅ Conectado a MongoDB';
    } catch (\Exception $e) {
        return '❌ Error: ' . $e->getMessage();
    }
});

Route::get('/test', function () {
    return response()->json(['message' => 'API funcionando']);
});

Route::get('/homefeed', [indexController::class, 'index']);

Route::get('/', [inicioController::class, 'inicio']);

Route::get('/inicio', [inicioController::class, 'inicio'])->name('inicio');

Route::get('/Información', [inicioController::class, 'Información'])->name('Información');

Route::get('/empresa', [inicioController::class, 'empresa'])->name('empresa');

Route::get('/Create', [inicioController::class, 'Create'])->name('Create');

Route::get('/News', [inicioController::class, 'News'])->name('News');

Route::get('/Login', [inicioController::class, 'Login'])->name('Login');

Route::get('/registro', [inicioController::class, 'registro'])->name('registro');

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

Route::get('/buscaIdea', [inicioController::class, 'buscaIdea'])->name('buscaIdea');
Route::get('/guardaIdeas', [inicioController::class, 'guardaIdeas'])->name('guardaIdeas');
Route::get('/crealo', [inicioController::class, 'crealo'])->name('crealo');
Route::get('/inicioLogueado', [inicioController::class, 'inicioLogueado'])->name('inicioLogueado');