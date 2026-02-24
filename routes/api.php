<?php

use App\Http\Controllers\Api\MobileFeedController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::post('/register', function (Request $request) {
    return response()->json([
        'message' => 'Ruta funcionando correctamente',
        'data' => $request->all()
    ]);
});

Route::prefix('mobile')->group(function () {
    Route::get('/pins', [MobileFeedController::class, 'index']);
    Route::post('/pins/upload', [MobileFeedController::class, 'uploadImage']);
    Route::post('/pins', [MobileFeedController::class, 'store']);
    Route::get('/pins/{pin}', [MobileFeedController::class, 'show'])->whereNumber('pin');
    Route::get('/pins/{pin}/comments', [MobileFeedController::class, 'comments'])->whereNumber('pin');
    Route::post('/pins/{pin}/comments', [MobileFeedController::class, 'addComment'])->whereNumber('pin');
    Route::delete('/pins/{pin}/comments/{comment}', [MobileFeedController::class, 'deleteComment'])->whereNumber('pin')->whereNumber('comment');
    Route::delete('/pins/{pin}', [MobileFeedController::class, 'destroy'])->whereNumber('pin');
    Route::get('/pins/{pin}/interactions', [MobileFeedController::class, 'interactions'])->whereNumber('pin');
    Route::post('/pins/{pin}/like', [MobileFeedController::class, 'setLike'])->whereNumber('pin');
    Route::post('/pins/{pin}/save', [MobileFeedController::class, 'setSaved'])->whereNumber('pin');
    Route::get('/saved-pins', [MobileFeedController::class, 'savedPins']);
    Route::get('/profiles/by-email', [MobileFeedController::class, 'profileByEmail']);
    Route::put('/profiles/by-email', [MobileFeedController::class, 'updateProfileByEmail']);
    Route::get('/profiles/{user}', [MobileFeedController::class, 'profileById'])->whereNumber('user');
});
