<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
    'prefix' => 'users',
], function () {
    Route::post('/register', [UserController::class, 'register']);

    Route::post('/verifyEmail', [UserController::class, 'verifyEmail']);
});
