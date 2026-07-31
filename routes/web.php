<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemPenjualanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;

//route yang bisa diakses ketika user belum login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/auth', [AuthController::class, 'auth'])->name('auth');
});

//route yang bisa diakses ketika user sudah login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
        // routes/web.php
// Ubah baris ini:
Route::post('/users/update/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/destroy/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    Route::middleware('role:admin,kasir')->group(function () {
        Route::resource('/produk', ProdukController::class);
        Route::resource('/penjualan', PenjualanController::class);

        // ✅ Samakan path dan nama route
        Route::post('/item-penjualan', [ItemPenjualanController::class, 'store'])->name('item-penjualan.store');
        Route::put('/item-penjualan/{itempenjualan}', [ItemPenjualanController::class, 'update'])->name('item-penjualan.update');
        Route::delete('/item-penjualan/{itempenjualan}', [ItemPenjualanController::class, 'destroy'])->name('item-penjualan.destroy');
        Route::post('/penjualan/{penjualan}/checkout', [PenjualanController::class, 'checkout'])->name('penjualan.checkout');
    });
});
