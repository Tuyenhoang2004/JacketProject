<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CartController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/signin', function () { return view('signin'); })->name('signin');
Route::get('/signup', function () { return view('signup'); })->name('signup');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/clear-cart', function () {
    session()->forget('cart');
    return 'Đã xóa giỏ hàng khỏi session!';
});


Route::get('/review', [ReviewController::class, 'create'])->name('review.create');
Route::post('/review', [ReviewController::class, 'store'])->name('review.store');

Route::get('/checkout', function () {
    return 'Đây là trang thanh toán';
})->name('checkout');


Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');





