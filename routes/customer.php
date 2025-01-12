<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CustomerProfileController;

// Customer login & register
Route::prefix('/')->group(function () {
    Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('customer.login');

    Route::post('/login', [CustomerAuthController::class, 'login'])->name('customer.login.submit');

    Route::middleware(['auth:web'])->group(function () {
        Route::get('/mypage', function () {
            return view('customer.profile'); 
        })->name('customer.profile');
    });

    Route::get('/entry', [CustomerAuthController::class, 'showRegisterForm'])->name('customer.register');
    Route::post('/entry', [CustomerAuthController::class, 'register']);
});

Route::get('/email/verify/{id}/{hash}', [CustomerAuthController::class, 'verifyEmail'])
    ->middleware(['signed'])
    ->name('verification.verify');

// Customer profile routes
Route::middleware(['auth:web'])->group(function () {
    Route::get('/mypage', [CustomerProfileController::class, 'show'])->name('customer.profile');
    Route::get('/mypage/edit', [CustomerProfileController::class, 'edit'])->name('mypage.edit');
    Route::post('/mypage/edit', [CustomerProfileController::class, 'update'])->name('mypage.update');
});

Route::post('/logout', function () {
    Auth::guard('web')->logout(); // Đăng xuất Customer
    return redirect()->route('customer.login'); // Chuyển hướng về trang login của Customer
})->middleware(['auth:web'])->name('customer.logout');