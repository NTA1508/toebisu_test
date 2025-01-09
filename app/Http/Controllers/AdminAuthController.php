<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('admin.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6|confirmed',
            'name' => 'nullable|string|max:255',
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $admin->sendEmailVerificationNotification();

        return redirect()->route('admin.register')->with('success', 'Đăng ký thành công, vui lòng kiểm tra email để xác thực.');
    }

    public function verifyEmail(Request $request)
    {
        return redirect()->route('admin.login')->with('success', 'Email đã được xác thực.');
    }

    public function showLoginForm()
    {
        return view('admin.login'); // Trả về view đăng nhập
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('admin')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập thành công!');
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ])->withInput($request->only('email', 'remember'));
    }
}
