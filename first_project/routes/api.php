<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'users'], function () {

    Route::post('/register', [UserController::class, 'register']);
    Route::post('/verifyEmail', [UserController::class, 'verifyEmail']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/forgetPassword', [UserController::class, 'forgetPassword']);
    Route::post('/verifyPassword', [UserController::class, 'verifyPassword']);
    Route::post('/setPassword', [UserController::class, 'setPassword']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/logout', [UserController::class, 'logout']);
        Route::post('/resetPassword', [UserController::class, 'resetPassword']);
    });
});

Route::group(['prefix' => 'products'], function () {

    Route::get('/allProducts', [ProductController::class, 'showAllProducts']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/addProduct', [ProductController::class, 'addProduct']);
        Route::put('/editProduct/{id}', [ProductController::class, 'editProduct']);
    });
});
