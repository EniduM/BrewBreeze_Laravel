<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// API Version 1
Route::prefix('v1')->group(function () {
    // Public routes with rate limiting (60 requests per minute)
    Route::middleware(['throttle:60,1'])->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
    });

    // Protected routes - require authentication with rate limiting (100 requests per minute)
    Route::middleware(['auth:sanctum', 'throttle:100,1'])->group(function () {
        // Logout
        Route::post('/logout', [AuthController::class, 'logout']);

        // Products - accessible to all authenticated users
        Route::get('/products', [ProductController::class, 'index']);

        // Cart - requires customer scope
        Route::post('/cart', [CartController::class, 'store'])
            ->middleware('ability:customer');

        // Orders - requires customer scope
        Route::get('/orders', [OrderController::class, 'index']);
        Route::post('/orders', [OrderController::class, 'store'])
            ->middleware('ability:customer');
        Route::get('/orders/{order}', [OrderController::class, 'show']);

        // Subscriptions - requires customer scope
        Route::get('/subscriptions', [SubscriptionController::class, 'index'])
            ->middleware('ability:customer');
        Route::post('/subscriptions', [SubscriptionController::class, 'store'])
            ->middleware('ability:customer');
        Route::delete('/subscriptions/{subscription}', [SubscriptionController::class, 'destroy'])
            ->middleware('ability:customer');

        // Get authenticated user
        Route::get('/user', function (Request $request) {
            return response()->json([
                'success' => true,
                'data' => [
                    'user' => [
                        'id' => $request->user()->id,
                        'name' => $request->user()->name,
                        'email' => $request->user()->email,
                        'role' => $request->user()->role,
                    ],
                ],
            ]);
        });
    });
});

// Backward compatibility - legacy routes without version prefix (to avoid breaking existing integrations)
Route::middleware(['throttle:60,1'])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth:sanctum', 'throttle:100,1'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store'])->middleware('ability:customer');
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store'])->middleware('ability:customer');
    Route::get('/orders/{order}', [OrderController::class, 'show']);
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->middleware('ability:customer');
    Route::post('/subscriptions', [SubscriptionController::class, 'store'])->middleware('ability:customer');
    Route::delete('/subscriptions/{subscription}', [SubscriptionController::class, 'destroy'])->middleware('ability:customer');
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => [
                'user' => [
                    'id' => $request->user()->id,
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                    'role' => $request->user()->role,
                ],
            ],
        ]);
    });
});
