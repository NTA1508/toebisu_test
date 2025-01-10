<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('customer.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'registration_id' => 'required|alpha_num|size:8',
            'password' => 'required|min:6',
        ], [
            'registration_id.required' => 'Vui lòng nhập registration_id.',
            'registration_id.size' => 'registration_id phải có đúng 8 ký tự.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ]);

        if (Auth::guard('web')->attempt($request->only('registration_id', 'password'), $request->filled('remember'))) {
            return redirect()->route('customer.profile')->with('success', 'Đăng nhập thành công!');
        }

        return back()->withErrors([
            'registration_id' => 'Registration ID hoặc mật khẩu không chính xác.',
        ])->withInput($request->only('registration_id', 'remember'));
    }
}
