<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClientController;
use App\Http\Controllers\JWTAuthController;

//API autentication routes
Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [JWTAuthController::class, 'login']);
    Route::post('register', [JWTAuthController::class, 'register']);
    Route::middleware('jwt')->group(function () {
        Route::post('logout', [JWTAuthController::class, 'logout']);
        Route::post('refresh', [JWTAuthController::class, 'refresh']);
        Route::post('me', [JWTAuthController::class, 'me']);
    });
});

//Client routes
Route::apiResource('client', ClientController::class);