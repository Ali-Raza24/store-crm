<?php

use App\Http\Controllers\Api\ApiLoginController;
use App\Http\Controllers\Api\DiscountController;
use App\Http\Controllers\Api\MyController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StoresController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UtilsController;

Route::group(['middleware' => ['onlyJson', 'auth.api']], function () {
    Route::post('/authToken', [ApiLoginController::class, 'login']);
});

Route::group(['middleware' => ['onlyJson', 'auth.api', 'auth.store']], function () {
    Route::post('/get-stores', [StoresController::class, 'index']);
    Route::post('/get-products', [ProductController::class, 'index']);
    Route::post('/payment-types', [UtilsController::class, 'paymentTypes']);
    Route::post('/states', [UtilsController::class, 'states']);
    Route::post('/store-areas', [StoresController::class, 'areas']);
    Route::post('/get-otp', [UtilsController::class, 'getOtp']);
    Route::post('/verify-otp', [UtilsController::class, 'verifyOtp']);
    Route::post('/validate-discount', [DiscountController::class, 'validateDiscount']);
    Route::post('/orders', [OrderController::class, 'save']);
    Route::post('/orders/validate', [OrderController::class, 'validateRequest']);

    Route::post('/login', [ApiLoginController::class, 'customerLogin']);
    Route::post('/register', [UserController::class, 'register']);

    Route::post('/forgot-password', [UserController::class, 'forgotPassword']);
    Route::post('/validate-code', [UserController::class, 'validateCode']);
    Route::post('/reset-password', [UserController::class, 'resetPassword']);
    Route::post('/verify/user', [UserController::class, 'verifyUser']);

    Route::post('/my-orders', [MyController::class, 'orders']);
    Route::post('/announcement', [UtilsController::class, 'announcement']);
    Route::post('/pages', [UtilsController::class, 'pages']);
    Route::post('/social-info', [UtilsController::class, 'socialLinks']);

    Route::post('/get-discount', [DiscountController::class, 'getDiscounts']);
    Route::post('/track-order/{id}', [OrderController::class, 'track']);

    Route::post('calculate_rate', [OrderController::class, 'calculate_rate']);
});
