<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserAuthController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\BookAutorController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('api_key')->group(function(){

    Route::post('register', [UserAuthController::class, 'register']);
    Route::post('login', [UserAuthController::class, 'login']);



    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [UserAuthController::class, 'logout']);
        Route::middleware('accecss')->group(function () {
            Route::resource('author', AuthorController::class);
            Route::resource('book', BookController::class);
        });

        Route::get('show_books', [BookAutorController::class, 'index']);
        Route::get('search_book', [BookAutorController::class, 'search']);
    
    });
});