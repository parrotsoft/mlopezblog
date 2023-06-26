<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ImportPostController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::post('register', RegisterController::class)->name('register');
    Route::post('login', LoginController::class)->name('login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::post('posts/import', ImportPostController::class)->name('posts.import');
        Route::apiResource('posts', PostController::class);
        Route::apiResource('categories', CategoryController::class);
    });
});
