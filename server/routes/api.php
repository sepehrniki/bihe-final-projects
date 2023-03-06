<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::prefix('/auth')->controller(AuthController::class)->group(function () {
        Route::post('/login', 'login')
            ->name('login');

        Route::post('/logout', 'logout')
            ->name('logout')
            ->middleware('auth:sanctum');
    });

    Route::prefix('/user')->name('user.')->controller(UserController::class)->middleware('auth:sanctum')->group(function () {
        Route::post('/create', 'create')
            ->name('create');

        Route::post('/edit', 'edit')
            ->name('edit');

        Route::delete('/delete/{id}', 'delete')
            ->name('delete');

        Route::get('/show/{id}', 'show')
            ->name('show');

        Route::get('/list', 'list')
            ->name('list');
    });

    Route::prefix('/project')->name('project.')->controller(ProjectController::class)->middleware('auth:sanctum')->group(function () {
        Route::post('/create', 'create')
            ->name('create');

        Route::post('/edit', 'edit')
            ->name('edit');

        Route::delete('/delete/{id}', 'delete')
            ->name('delete');

        Route::get('/show/{id}', 'show')
            ->name('show');

        Route::get('/list', 'list')
            ->name('list');
    });
});
