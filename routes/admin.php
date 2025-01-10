<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AdminMemberController;
use Illuminate\Support\Facades\Auth;

Auth::routes(['verify' => true]);
//Admin login and register
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });

    Route::get('/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
    Route::post('/register', [AdminAuthController::class, 'register']);
});

Route::get('/email/verify/{id}/{hash}', [AdminAuthController::class, 'verifyEmail'])
    ->middleware(['signed'])
    ->name('verification.verify');

// Admin member routes
Route::prefix('admin/member')->group(function () {
    Route::get('/new', [AdminMemberController::class, 'create'])->name('admin.member.create');
    Route::post('/new', [AdminMemberController::class, 'store'])->name('admin.member.store');
    Route::get('/{id}/edit', [AdminMemberController::class, 'edit'])->name('admin.member.edit');
    Route::post('/{id}/edit', [AdminMemberController::class, 'update'])->name('admin.member.update');
    Route::get('/', [AdminMemberController::class, 'index'])->name('admin.member.index');
    Route::get('/export-csv', [AdminMemberController::class, 'exportCsv'])->name('admin.member.exportCsv');
});

// Admin customer routes
Route::prefix('admin/customer')->group(function () {
    Route::get('/new', [AdminCustomerController::class, 'create'])->name('admin.customer.create');
    Route::post('/new', [AdminCustomerController::class, 'store'])->name('admin.customer.store');
    Route::get('/{id}/edit', [AdminCustomerController::class, 'edit'])->name('admin.customer.edit');
    Route::post('/{id}/edit', [AdminCustomerController::class, 'update'])->name('admin.customer.update');
    Route::get('/', [AdminCustomerController::class, 'index'])->name('admin.customer.index');
    Route::get('/export-csv', [AdminCustomerController::class, 'exportCsv'])->name('admin.customer.exportCsv');
});
