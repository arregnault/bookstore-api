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

// Authentication

Route::post('/auth/login', [AuthController::class, 'login'])->name('login');


// Books
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('auth/me', [AuthController::class, 'me'])->name('me');
    Route::get('auth/transactions', [AuthController::class, 'transactions'])->name('transactions');


    Route::post('books/reservation/{id}', [BooksController::class, 'reservation'])->name('books-reservation');
    Route::post('books/discount/{id}', [BooksController::class, 'discount'])->name('books-discount');
    Route::resource('books', BooksController::class, [ 'except' => ['create', 'edit'], ])->name('*', 'books');

    
    Route::resource('promotion-help', PromotionHelpController::class, [ 'except' => ['create', 'edit', 'update', 'destroy'], ])->name('*', 'promotion-help');
    Route::post('promotion-help/donation/{id}', [PromotionHelpController::class, 'donation'])->name('promotion-help-donation');
});
