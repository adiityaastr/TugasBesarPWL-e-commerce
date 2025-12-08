<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

// Public Routes (redirect admin away)
Route::middleware('no_admin_shop')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('home');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
});

// Customer Routes (Auth required)
Route::middleware(['auth', 'verified', 'no_admin_shop'])->group(function () {
    // User Dashboard (Order History)
    Route::get('/dashboard', [OrderController::class, 'index'])->name('dashboard');
    
    // Cart Routes
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [\App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{cart}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [\App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');

    // Checkout
    Route::get('/checkout', [OrderController::class, 'create'])->name('checkout.index');
    
    // Order Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
    Route::patch('/orders/{order}/cancel', \App\Http\Controllers\OrderCancelController::class)->name('orders.cancel');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Product Management
    Route::get('/products', [ProductController::class, 'adminIndex'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Order Management
    Route::get('/orders', [AdminDashboardController::class, 'orders'])->name('orders.index');
    Route::patch('/orders/{order}', [AdminDashboardController::class, 'updateOrderStatus'])->name('orders.update');
    Route::post('/orders/{order}/approve-cancellation', [AdminDashboardController::class, 'approveCancellation'])->name('orders.approve-cancellation');
    Route::post('/orders/{order}/reject-cancellation', [AdminDashboardController::class, 'rejectCancellation'])->name('orders.reject-cancellation');

    // Reports
    Route::get('/reports', [AdminDashboardController::class, 'reports'])->name('reports.index');
});

require __DIR__.'/auth.php';
