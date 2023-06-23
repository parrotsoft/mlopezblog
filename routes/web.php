<?php

use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\OrderController;
use App\Http\Controllers\Web\PaymentController;
use App\Http\Controllers\Web\PostController;
use App\Http\Controllers\Web\PostExportController;
use App\Http\Controllers\Web\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('categories', CategoryController::class)->only([
        'index',
        'create',
        'show',
        'store',
        'update',
        'destroy'
    ]);
    Route::get('posts/exports', PostExportController::class)->name('posts.export');
    Route::resource('posts', PostController::class)->only(['index', 'create', 'show', 'store', 'update', 'destroy']);

    Route::resource('orders', OrderController::class)->only(['index']);

    Route::get('payments/{post_id}', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('payments', [PaymentController::class, 'processPayment'])->name('payments.processPayment');
    Route::get('payments/payment/response', [PaymentController::class, 'processResponse'])->name('payments.processResponse');
});

require __DIR__ . '/auth.php';
