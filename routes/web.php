<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Order\OrderController;

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/browse', [ProductController::class,'browse'])->name('products.browse');
Route::get('/product/{product}', [ProductController::class,'show'])->name('products.show');

// Admin area
Route::middleware(['auth','can:admin-access'])->prefix('admin')->name('admin.')->group(function(){
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class,'index'])->name('dashboard');
    
    // Products Management
    Route::get('/products', [AdminProductController::class,'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class,'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class,'store'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminProductController::class,'edit'])->name('products.edit');
    Route::put('/products/{product}', [AdminProductController::class,'update'])->name('products.update');
    
    // Orders Management
    Route::get('/orders', [AdminOrderController::class,'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class,'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [AdminOrderController::class,'updateStatus'])->name('orders.updateStatus');
    
    // Customers Management
    Route::get('/customers', [AdminCustomerController::class,'index'])->name('customers.index');
    Route::get('/customers/{user}', [AdminCustomerController::class,'show'])->name('customers.show');
    Route::post('/customers/{user}/ban', [AdminCustomerController::class,'ban'])->name('customers.ban');
    Route::post('/customers/{user}/unban', [AdminCustomerController::class,'unban'])->name('customers.unban');
});

// Auth routes (login, register, etc.)
require __DIR__.'/auth.php';

// Default dashboard expected by auth scaffolding/tests
Route::get('/dashboard', function(){ return view('dashboard'); })
    ->middleware(['auth','verified'])
    ->name('dashboard');

// Authenticated user routes
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Cart and Checkout
    Route::get('/cart', [CartController::class,'index'])->name('cart.index');
    Route::get('/cart/items.json', [CartController::class,'itemsJson'])->name('cart.items.json');
    Route::post('/cart/add/{product}', [CartController::class,'add'])->name('cart.add');
    Route::post('/cart/update/{product}', [CartController::class,'updateQuantity'])->name('cart.update');
    Route::delete('/cart/remove/{product}', [CartController::class,'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class,'clear'])->name('cart.clear');
    Route::post('/cart/checkout', [CartController::class,'checkout'])->name('cart.checkout');
    
    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/confirmation', [OrderController::class, 'confirmation'])->name('orders.confirmation');
});