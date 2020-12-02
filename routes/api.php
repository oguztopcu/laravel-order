<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->namespace('Auth')->group(function () {
    Route::post('/login', [LoginController::class, 'login'])->name('api.auth.login');

    Route::get('/logout', [LoginController::class, 'logout'])->name('api.auth.logout');
});
