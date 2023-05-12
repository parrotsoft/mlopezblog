<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
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
    Route::resource('posts', PostController::class)->only(['index', 'create', 'show', 'store', 'update', 'destroy']);

    Route::get('payments/{post_id}', [PaymentController::class, 'create'])->name('payments.create');


    Route::post('payments', [PaymentController::class, 'processPayment'])->name('payments.processPayment');
    Route::get('payments/status/return', [PaymentController::class, 'returnPayment'])->name('payments.return');
    Route::get('payments/status/cancel', [PaymentController::class, 'cancelPayment'])->name('payments.cancel');
});

require __DIR__ . '/auth.php';
