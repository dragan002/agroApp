<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FarmerController;
use App\Http\Controllers\Api\OnboardingController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\StateController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/farmer/{id}', function (int $id) {
    return view('welcome', ['openFarmerId' => $id]);
});

// API routes (CSRF excluded via bootstrap/app.php validateCsrfTokens except)
Route::prefix('api')->group(function () {

    // Public
    Route::get('state', [StateController::class, 'index']);
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::get('farmers', [FarmerController::class, 'index']);
    Route::get('farmers/{id}', [FarmerController::class, 'show']);
    Route::get('farmers/{id}/reviews', [ReviewController::class, 'index']);
    Route::post('farmers/{id}/reviews', [ReviewController::class, 'store']);
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{id}', [ProductController::class, 'show']);
    Route::get('search', [SearchController::class, 'search']);

    // Auth required
    Route::middleware('auth')->group(function () {
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::get('auth/me', [AuthController::class, 'me']);

        // Admin only
        Route::middleware('admin')->prefix('admin')->group(function () {
            Route::get('farmers', [AdminController::class, 'farmers']);
            Route::patch('farmers/{id}/approve', [AdminController::class, 'approveFarmer']);
            Route::patch('farmers/{id}/reject', [AdminController::class, 'rejectFarmer']);
            Route::get('products', [AdminController::class, 'products']);
            Route::delete('products/{id}', [AdminController::class, 'deleteProduct']);
            Route::get('reviews', [ReviewController::class, 'adminIndex']);
            Route::delete('reviews/{id}', [ReviewController::class, 'destroy']);
        });

        // Farmer only
        Route::middleware('farmer')->group(function () {
            Route::post('onboarding/step/2', [OnboardingController::class, 'step2']);
            Route::post('onboarding/step/3', [OnboardingController::class, 'step3']);
            Route::post('onboarding/step/4', [OnboardingController::class, 'step4']);
            Route::post('onboarding/complete', [OnboardingController::class, 'complete']);
            Route::match(['POST', 'PATCH'], 'farmer/profile', [FarmerController::class, 'update']);
            Route::post('farmer/photos', [FarmerController::class, 'addPhotos']);
            Route::delete('farmer/photos/{photoId}', [FarmerController::class, 'deletePhoto']);
            Route::get('farmer/products', [ProductController::class, 'myProducts']);
            Route::post('farmer/products', [ProductController::class, 'store']);
            Route::match(['POST', 'PATCH'], 'farmer/products/{id}', [ProductController::class, 'update']);
            Route::patch('farmer/products/{id}/fresh', [ProductController::class, 'setFreshUntil']);
            Route::delete('farmer/products/{id}', [ProductController::class, 'destroy']);
            Route::delete('farmer/products/{id}/photos/{photoId}', [ProductController::class, 'deletePhoto']);
        });
    });
});
