<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;

/*
|---------------------------------------------------------------------------
| Web Routes
|---------------------------------------------------------------------------
*/

// --- FRONTEND ROUTES ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/signin', function () { return view('signin'); })->name('signin');
Route::get('/signup', function () { return view('signup'); })->name('signup');
Route::get('/cart', function () { return view('cart'); })->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/review', [ReviewController::class, 'create'])->name('review.create');
Route::post('/review', [ReviewController::class, 'store'])->name('review.store');

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');

// =================== ADMIN ===================
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('dashboard');

// Orders
Route::get('admin/statistics', [OrderController::class, 'statistics'])->name('admin.statistics');
Route::get('admin/orders/details', [OrderController::class, 'details'])->name('admin.orders.details');
Route::get('admin/orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
Route::get('admin/order-statistics', [OrderController::class, 'orderstatistics'])->name('admin.orders.order-statistics');

// Users
Route::prefix('admin/users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

// Products
Route::resource('products', ProductController::class);
Route::put('/products/{ProductID}/update-stock', [ProductController::class, 'updateStock'])->name('products.updateStock');

