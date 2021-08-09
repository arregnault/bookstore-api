<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BooksController;

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
    Route::resource('books', BooksController::class, [ 'except' => ['create', 'edit'], ])->name('*', 'books');
});
