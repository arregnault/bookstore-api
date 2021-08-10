<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BooksController;
use App\Http\Controllers\Api\PromotionHelpController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Auth

Route::post('/auth/login', [AuthController::class, 'login'])->name('auth-login');




Route::group(['middleware' => ['auth:sanctum']], function () {

    
    // Auth
    Route::get('auth/me', [AuthController::class, 'me'])->name('auth-me');
    Route::get('auth/transactions', [AuthController::class, 'transactions'])->name('auth-transactions');


    
    Route::group([
        'middleware' => 'role:reader'
    ], function () {
        // Books
        Route::post('books/reservation/{id}', [BooksController::class, 'reservation'])->name('books-reservation');
        // Promotions
        Route::post('promotion-help/donation/{id}', [PromotionHelpController::class, 'donation'])->name('promotion-help-donation');
    });

    Route::group([
        'middleware' => 'role:author'
    ], function () {
        // Books
        Route::post('books/discount/{id}', [BooksController::class, 'discount'])->name('books-discount');
        Route::get('books/report', [BooksController::class, 'pdfReport'])->name('books-report');
        Route::resource('books', BooksController::class, [ 'only' => ['store', 'update', 'destroy'], ])->name('*', 'books');

        // Promotions
        Route::resource('promotion-help', PromotionHelpController::class, [ 'except' => ['create', 'edit', 'update', 'destroy'], ])->name('*', 'promotion-help');
    });

    
    // Books
    Route::resource('books', BooksController::class, [ 'except' => ['create', 'edit', 'store', 'update', 'destroy'], ])->name('*', 'books');
});
