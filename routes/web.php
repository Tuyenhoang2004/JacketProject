<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
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
Route::get('/cart', function () { return view('cart'); })->name('cart');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/review', [ReviewController::class, 'create'])->name('review.create');
Route::post('/review', [ReviewController::class, 'store'])->name('review.store');

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');





