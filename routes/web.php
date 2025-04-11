<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

// Tạo đầy đủ route CRUD cho products: index, create, store, show, edit, update, destroy
Route::resource('products', ProductController::class);

// Route bổ sung riêng (nếu có xử lý tồn kho)
Route::put('/products/{ProductID}/update-stock', [ProductController::class, 'updateStock'])->name('products.updateStock');
