<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CustomerProfileController;

// Customer login & register
Route::prefix('/')->group(function () {
    Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('customer.login');

    Route::post('/login', [CustomerAuthController::class, 'login'])->name('customer.login.submit');

    Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');

    Route::middleware(['auth:web'])->group(function () {
        Route::get('/mypage', function () {
            return view('customer.profile'); 
        })->name('customer.profile');
    });
});

// Customer profile routes
Route::middleware(['auth:web'])->group(function () {
    Route::get('/mypage', [CustomerProfileController::class, 'show'])->name('customer.profile');
    Route::get('/mypage/edit', [CustomerProfileController::class, 'edit'])->name('mypage.edit');
    Route::post('/mypage/edit', [CustomerProfileController::class, 'update'])->name('mypage.update');
});
