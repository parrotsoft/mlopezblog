<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ImportPostController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RegisterController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::post('register', RegisterController::class)->name('register');
    Route::post('login', LoginController::class)->name('login');

    Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
        Route::apiSingleton('profile', ProfileController::class)->destroyable();

        Route::apiResource('posts', PostController::class);
        Route::post('posts/import', ImportPostController::class)->name('posts.import');

        Route::get('categories', [CategoryController::class, 'index']);
    });
});
