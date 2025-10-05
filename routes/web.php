<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\indexController;




Route::get('/test', function () {
    return response()->json(['message' => 'API funcionando']);
});

Route::get('/', [indexController::class, 'index']);
