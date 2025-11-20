<?php

use App\Http\Controllers\inicioController;
use App\Http\Controllers\userController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('LOGIN', [inicioController::class, 'login']);
