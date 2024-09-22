<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\StatusController;
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
    Route::put('/setPassword', [UserController::class, 'setPassword']);
    Route::get('/products/{user_id}', [UserController::class, 'getProducts']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/logout', [UserController::class, 'logout']);
        Route::post('/resetPassword', [UserController::class, 'resetPassword']);
        Route::put('/resetPassword', [UserController::class, 'resetPassword']);
        Route::get('/showUser', [UserController::class, 'show']);
        Route::put('/editUser', [UserController::class, 'edit']);
    });
});

Route::group(['prefix' => 'products'], function () {

    Route::get('/manyProducts/{number}', [ProductController::class, 'showManyProducts']);
    Route::get('/oneProduct/{product_id}', [ProductController::class, 'showOneProduct']);

    Route::group(['prefix' => 'filterBy'], function () {
        Route::get('/name/{product_name}', [ProductController::class, 'filterProductsByName']);
        Route::get('/category/{category_id}', [ProductController::class, 'filterProductsByCategory']);
        Route::get('/expirationDate/{expiration_date}', [ProductController::class, 'filterProductsByExpirationDate']);
    });

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/addProduct', [ProductController::class, 'addProduct']);
        Route::put('/editProduct/{product_id}', [ProductController::class, 'editProduct']);
        Route::delete('/deleteProduct/{product_id}', [ProductController::class, 'deleteProduct']);
    });
});

Route::group(['prefix' => 'contacts'], function () {

    Route::get('/allForUser/{user_id}', [ContactController::class, 'showContactInfo']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/addContactInfo', [ContactController::class, 'addInfo']);
        Route::get('/allTypes', [ContactController::class, 'showContactType']);
    });
});

Route::get('categories', [CategoryController::class, 'getCategories']);

Route::group(['prefix' => 'ratings'], function () {
    Route::get('/showProductRatings/{number}/{product_id}', [RatingController::class, 'showProductRatings']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/addRating/{product_id}', [RatingController::class, 'addRating']);
    });
});

Route::group(['prefix' => 'statuses'], function () {
    Route::get('/allStatuses', [StatusController::class, 'allStatuses']);
});