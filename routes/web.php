<?php

use App\Http\Controllers\Auth\CustomerLoginController;
use App\Http\Controllers\Auth\AdminLoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/about', function () {
    return view('about');
})->name('about');

// Customer Login Routes
Route::get('/login', [CustomerLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [CustomerLoginController::class, 'store'])
    ->middleware(['web', 'throttle:login'])
    ->name('login.post');

// Admin Login Routes
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'store'])
    ->middleware(['web', 'throttle:login'])
    ->name('admin.login.post');

// Public Products route - accessible to everyone
Route::get('/products', function () {
    return view('customer.products');
})->name('customer.products');

Route::get('/products/{product}', function ($product) {
    return view('customer.product-detail', ['productId' => $product]);
})->name('customer.products.show');

// Products route - accessible to both customers and admins (view-only for admins)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Products are now public, these routes are kept for backward compatibility
    // but redirect to the public routes
});

// Customer-only routes (ordering, cart, checkout, orders, messages)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'customer',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('customer.dashboard');
    })->name('dashboard');

    Route::get('/cart', function () {
        return view('customer.cart');
    })->name('customer.cart');

    Route::get('/checkout', function () {
        return view('customer.checkout');
    })->name('customer.checkout');

    Route::get('/orders', function () {
        return view('customer.orders');
    })->name('customer.orders');

    Route::get('/orders/{order}', function ($order) {
        return view('customer.order-detail', ['orderId' => $order]);
    })->name('customer.orders.show');

    Route::get('/message', function () {
        return view('customer.message');
    })->name('customer.message');
});

// Admin routes - protected by admin middleware
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'admin',
])->prefix('admin')->name('admin.')->group(function () {
    // Admin dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Product management routes
    Route::get('/products', function () {
        return view('admin.products');
    })->name('products.index');

    // Order management routes
    Route::get('/orders', function () {
        return view('admin.orders');
    })->name('orders.index');

    // Subscription management routes
    Route::get('/subscriptions', function () {
        return view('admin.subscriptions');
    })->name('subscriptions.index');

    // Messages management routes
    Route::get('/messages', function () {
        return view('admin.messages');
    })->name('messages.index');
});

// Customer routes - protected by authentication (legacy routes, kept for compatibility)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // These routes are now handled by the customer middleware group above

    // Subscription routes
    Route::get('/subscriptions', function () {
        return view('customer.subscriptions');
    })->name('customer.subscriptions');
});
