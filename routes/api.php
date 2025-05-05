<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Api\UserApiController;
use App\Http\Controllers\Frontend\Api\HomeApiController;
use App\Http\Controllers\Admin\Api\CategoryApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------

*/

// Route::post('/register', [UserApiController::class, 'register']);
// Route::post('/login', [UserApiController::class, 'login']);
// Route::post('/reset-password/{token}', [UserApiController::class, 'reset']);
// Route::post('/forgot-password', [UserApiController::class, 'forgotPassword']);

// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/logout', [UserApiController::class, 'logout']);
//     Route::post('/change-password', [UserApiController::class, 'updatePassword']);
//     Route::get('/profile', [UserApiController::class, 'profile']);
//     Route::put('/profile', [UserApiController::class, 'editProfile']);
//     Route::apiResource('categories', CategoryApiController::class);
// });


Route::prefix('api')->group(function () {
    Route::post('/register', [UserApiController::class, 'register']);
    Route::post('/login', [UserApiController::class, 'login']);
    Route::post('/reset-password/{token}', [UserApiController::class, 'reset']);
    Route::post('/forgot-password', [UserApiController::class, 'forgotPassword']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [UserApiController::class, 'logout']);
        Route::get('/email-verification', [UserApiController::class, 'sendemailVerification']);
        Route::post('/email-verification', [UserApiController::class, 'emailVerification']);
        Route::post('/change-password', [UserApiController::class, 'updatePassword']);
        Route::get('/profile', [UserApiController::class, 'profile']);
        Route::put('/profile', [UserApiController::class, 'editProfile']);
    });
    // Home
    Route::get('/homepage', [HomeApiController::class, 'homePage']);
    Route::get('/home-sliders', [HomeApiController::class, 'homeSliders']);
    Route::get('/categories', [HomeApiController::class, 'AllCategory']);
    Route::get('/brands', [HomeApiController::class, 'AllBrand']);
    Route::get('product/details/{slug}', [HomeApiController::class, 'productDetails'])->name('product.details');

});
