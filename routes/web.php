<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;


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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('dashboard');

Route::get('admin/statistics', [OrderController::class, 'statistics'])->name('admin.statistics');
Route::get('admin/orders/details', [OrderController::class, 'details'])->name('admin.orders.details');
Route::get('admin/orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
Route::get('admin/order-statistics', [OrderController::class, 'orderstatistics'])
    ->name('admin.orders.order-statistics');

Route::prefix('admin/users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });
    




