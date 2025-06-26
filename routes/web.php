<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('profile');
})->name('profile');


// Authentication Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Common Dashboard Route (Auth Required)
Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Routes for all logged-in users
Route::middleware(['auth'])->group(function () {
    
    // ✅ USER ROUTES
    Route::get('/products', [OrderController::class, 'showProducts'])->name('products.list');
    Route::post('/order/{id}', [OrderController::class, 'placeOrder'])->name('order.place');
    Route::get('/my-orders', [OrderController::class, 'userOrders'])->name('orders.user');
    Route::get('/products/{id}', [ProductController::class, 'showdetail'])->name('products.details');
    Route::post('/order/{id}/cancel', [OrderController::class, 'cancelorder'])->name('order.cancel');


    // ✅ ADMIN ROUTES
    Route::middleware('admin')->group(function () {
        // Product Management
        Route::get('/admin/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/admin/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/admin/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/admin/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

        // Order View for Admin
        Route::get('/all-orders', [OrderController::class, 'allOrders'])->name('orders.all');
        // Manage users
Route::get('/admin/users', [DashboardController::class, 'manageUsers'])->name('admin.users');
Route::delete('/admin/users/{user}', [DashboardController::class, 'deleteUser'])->name('admin.users.delete');

// Update order status
Route::post('/admin/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    });

});




