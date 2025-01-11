<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Auth\Events\Verified;

use Illuminate\Support\Facades\Log;

class AdminAuthController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegisterForm()
    {
        return view('admin.register');
    }

    /**
     * Handle registration request.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'registration_id' => 'required|unique:admins,registration_id|size:8',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6|confirmed',
            'name' => 'nullable|string|max:255',
        ], [
            'registration_id.required.' => 'Vui lòng nhập mã đăng ký.',
            'registration_id.unique' => 'Mã đăng ký đã được sử dụng.',
            'registration_id.size' => 'Mã đăng ký phải có độ dài 8 ký tự.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        try {
            $admin = Admin::create([
                'registration_id' => $validated['registration_id'],
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $admin->sendEmailVerificationNotification();

            return redirect()->route('admin.register')->with('success', 'Đăng ký thành công, vui lòng kiểm tra email để xác thực.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Đã xảy ra lỗi khi đăng ký: ' . $e->getMessage()])->withInput();
        }
    }

    public function verifyEmail(Request $request, $id, $hash)
    {
        $admin = Admin::findOrFail($id);
    
        if (!hash_equals((string) $hash, sha1($admin->getEmailForVerification()))) {
            abort(403, 'URL xác minh không hợp lệ.');
        }
    
        if ($admin->hasVerifiedEmail()) {
            return redirect()->route('admin.login')->with('info', 'Email đã được xác minh trước đó.');
        }
    
        $admin->markEmailAsVerified();
        event(new Verified($admin));
    
        return redirect()->route('admin.login')->with('success', 'Email đã được xác minh thành công.');
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'registration_id' => 'required|alpha_num|size:8',
            'password' => 'required|min:6',
        ], [
            'registration_id.required' => 'Vui lòng nhập mã đăng ký.',
            'registration_id.size' => 'Mã đăng ký phải có đúng 8 ký tự.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ]);
    
        if (Auth::guard('admin')->attempt($validated, $request->filled('remember'))) {
            $user = Auth::guard('admin')->user();
    
            if (is_null($user->email_verified_at)) {
                Auth::guard('admin')->logout();
                return back()->withErrors([
                    'registration_id' => 'Tài khoản của bạn chưa xác minh email. Vui lòng kiểm tra email để xác minh.',
                ])->withInput($request->only('registration_id', 'remember'));
            }
    
            return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập thành công!');
        }

        return back()->withErrors([
            'registration_id' => 'Mã đăng ký hoặc mật khẩu không chính xác.',
        ])->withInput($request->only('registration_id', 'remember'));
    }    
}
