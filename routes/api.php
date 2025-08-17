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
        Route::get('logout', [JWTAuthController::class, 'logout']);
        Route::get('refresh', [JWTAuthController::class, 'refresh']);
        Route::get('me', [JWTAuthController::class, 'me']);
    });
});

//Client routes
Route::group([
    'prefix' => 'v1',
    'middleware' => 'jwt'
],function () {
    Route::apiResource('client', ClientController::class);
});