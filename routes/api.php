<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClientController;
use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\VOIPController;

Route::prefix('auth')->group(function () {
    Route::post('login', [JWTAuthController::class, 'login']);
    Route::post('register', [JWTAuthController::class, 'register']);

    Route::middleware('jwt')->group(function () {
        Route::get('logout', [JWTAuthController::class, 'logout']);
        Route::get('refresh', [JWTAuthController::class, 'refresh']);
        Route::get('me', [JWTAuthController::class, 'me']);
    });
});

// Rotas protegidas por JWT
Route::middleware('jwt')->group(function () {
    Route::prefix('voip')->group(function () {
        Route::post('call/{id}', [VOIPController::class, 'call']);
    });

    Route::prefix('v1')->group(function () {
        Route::apiResource('clients', ClientController::class);
    });
});