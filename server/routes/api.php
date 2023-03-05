<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::prefix('/user')->controller(AuthController::class)->group(function () {
        Route::post('/login', 'login')
            ->name('login');

        Route::post('/register', 'register')
            ->name('register')
            ->middleware(['auth:sanctum']);

        Route::post('/logout', 'logout')
            ->name('logout')
            ->middleware('auth:sanctum');
    });



});
