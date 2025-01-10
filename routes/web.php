<?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\AdminAuthController;
// use App\Http\Controllers\CustomerAuthController;
// use App\Http\Controllers\CustomerProfileController;
// use App\Http\Controllers\AdminCustomerController;
// use App\Http\Controllers\AdminMemberController;
// use Illuminate\Foundation\Auth\EmailVerificationRequest;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

/*
|---------------------------------------------------------------------------
| Web Routes
|---------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes(['verify' => true]);

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/admin.php';

require __DIR__.'/customer.php';

require __DIR__.'/auth.php';

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
