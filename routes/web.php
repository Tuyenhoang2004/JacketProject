<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserController;

// Trang chủ, tìm kiếm, đăng nhập đăng ký
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/signin', fn() => view('signin'))->name('signin');
Route::get('/signup', fn() => view('signup'))->name('signup');

// Đăng xuất
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// Giỏ hàng
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/clear-cart', function () {
    session()->forget('cart');
    return 'Đã xóa giỏ hàng khỏi session!';
});

// Đánh giá sản phẩm
Route::get('/review', [ReviewController::class, 'create'])->name('review.create');
Route::post('/review', [ReviewController::class, 'store'])->name('review.store');

// Chi tiết sản phẩm
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');

// ========================

// Bước 2: Xác nhận thông tin vận chuyển (POST)
Route::post('/checkout/confirm-shipping', [CheckoutController::class, 'confirmShipping'])->name('checkout.confirmShipping');


Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

// Bước 3: Xử lý thanh toán (POST)
Route::post('/checkout/process-payment', [CheckoutController::class, 'processPayment'])->name('checkout.processPayment');

// Trang thông báo thanh toán thành công
Route::get('/checkout/success', fn() => view('checkout_success'))->name('checkout.success');
