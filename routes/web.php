<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Đây là nơi bạn định nghĩa các route cho ứng dụng Laravel của mình.
| Route::resource sẽ tự tạo đầy đủ route CRUD cho bạn.
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Routes cho products (CRUD + update stock)
Route::resource('products', ProductController::class);
Route::put('/products/{ProductID}/update-stock', [ProductController::class, 'updateStock'])->name('products.updateStock');

// Admin Dashboard
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('dashboard');

// Order-related admin routes
Route::get('admin/statistics', [OrderController::class, 'statistics'])->name('admin.statistics');
Route::get('admin/orders/details', [OrderController::class, 'details'])->name('admin.orders.details');
Route::get('admin/orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
Route::get('admin/order-statistics', [OrderController::class, 'orderstatistics'])->name('admin.orders.order-statistics');

// User management routes
Route::prefix('admin/users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});
