<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::post('/register', function (Request $request) {
    return response()->json([
        'message' => 'Ruta funcionando correctamente',
        'data' => $request->all()
    ]);
});