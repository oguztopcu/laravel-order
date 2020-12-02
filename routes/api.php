<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->namespace('Auth')->group(function () {
    Route::post('/login', [LoginController::class, 'login'])->name('api.auth.login');

    Route::get('/logout', [LoginController::class, 'logout'])->name('api.auth.logout');
});

Route::prefix('customer')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('api.customer.index');

    Route::post('/', [CustomerController::class, 'store'])->name('api.customer.store');

    Route::get('/{customerId}', [CustomerController::class, 'show'])->name('api.customer.show');
    Route::put('/{customerId}', [CustomerController::class, 'update'])->name('api.customer.update');

    Route::delete('/{customerId}', [CustomerController::class, 'destroy'])->name('api.customer.destroy');
});
