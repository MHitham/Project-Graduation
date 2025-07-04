<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\FertilizerController;
use App\Http\Controllers\GoodImagesController;
use App\Http\Controllers\IdentityMiddleware\AuthController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentMethodsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SeasonsController;
use App\Http\Controllers\SoilController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/auth', [AuthController::class, 'show'])->middleware('auth');

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('register', 'register');
    Route::post('verify-email', 'verifyEmail');
    Route::post('resend-email-verification-code', 'resendEmailVerificationCode');
    Route::post('login', 'login');
    Route::post('login2fa', 'login2fa');
    Route::get('logout', 'logout');
    Route::post('forget-password', 'forgetPassword');
    Route::post('reset-password', 'resetPassword');
});

Route::controller(FertilizerController::class)->prefix('fertilizer')->group(function () {
    Route::post('', 'add');
    Route::put('', 'update');
    Route::get('{name}', 'get');
    Route::delete('{name}', 'delete');
    Route::get('', 'getAll');
});


Route::controller(DiseaseController::class)->prefix('disease')->group(function () {
    Route::post('', 'add');
    Route::put('', 'update');
    Route::get('{name}', 'get');
    Route::delete('{name}', 'delete');
    Route::get('', 'getAll');
});

Route::controller(SoilController::class)->prefix('soil')->group(function () {
    Route::post('', 'add');
    Route::put('', 'update');
    Route::get('{name}', 'get');
    Route::delete('{name}', 'delete');
    Route::get('', 'getAll');
});

Route::controller(SeasonsController::class)->prefix('season')->group(function () {
    Route::post('', 'add');
    Route::put('', 'update');
    Route::get('{name}', 'get');
    Route::delete('{name}', 'delete');
    Route::get('', 'getAll');
});

Route::controller(CategoryController::class)->prefix('category')->group(function () {
    Route::post('', 'add');
    Route::put('', 'update');
    Route::get('{name}', 'get');
    Route::delete('{name}', 'delete');
    Route::get('', 'getAll');
});

Route::controller(ImageController::class)->prefix('image')->group(function () {
    Route::post('', 'add');
    Route::put('', 'update');
    Route::get('{id}', 'get');
    Route::delete('{id}', 'delete');
    Route::get('', 'getAll');
});

Route::controller(PaymentMethodsController::class)->prefix('payment-methods')->group(function () {
    Route::post('', 'add');
    Route::put('', 'update');
    Route::get('{name}', 'get');
    Route::delete('{name}', 'delete');
    Route::get('', 'getAll');
});

Route::controller(CartController::class)->prefix('cart')->group(function () {
    Route::post('', 'add');
    Route::put('', 'update');
    Route::get('{id}', 'get');
    Route::delete('{id}', 'delete');
    Route::get('', 'getAll');
});

Route::controller(GoodImagesController::class)->prefix('good-images')->group(function () {
    Route::post('', 'add');
    Route::put('', 'update');
    Route::get('{id}', 'get');
    Route::delete('{id}', 'delete');
    Route::get('', 'getAll');
});

Route::controller(ProductsController::class)->prefix('product')->group(function () {
    Route::post('', 'add');
    Route::put('', 'update');
    Route::get('{id}', 'get');
    Route::delete('{id}', 'delete');
    Route::get('', 'getAll');
});

Route::controller(CartController::class)->prefix('cart')->group(function () {
    Route::post('', 'add');
    Route::put('', 'update');
    Route::get('{id}', 'get');
    Route::delete('{id}', 'delete');
    Route::get('', 'getAll');
});

Route::controller(OrderController::class)->prefix('order')->group(function () {
    Route::post('', 'add');
    Route::put('', 'update');
    Route::get('{id}', 'get');
    Route::delete('{id}', 'delete');
    Route::get('', 'getAll');
});

Route::controller(PaymentController::class)->prefix('payment')->group(function () {
    Route::post('', 'add');
    Route::put('', 'update');
    Route::get('{id}', 'get');
    Route::delete('{id}', 'delete');
    Route::get('', 'getAll');
});