<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Auth\Events\Verified;
use App\Notifications\VerifyEmailCustom;

use Illuminate\Support\Facades\Log;

class AdminAuthController extends Controller
{
    public function sendVerificationEmail(Admin $admin)
    {
        // Send the custom verification email
        $admin->notify(new VerifyEmailCustom($admin));
    }
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
            'registration_id' => 'required|unique:admins,registration_id|unique:customers,registration_id|size:8',
            'email' => 'required|email|unique:admins,email|unique:customers,email',
            'password' => 'required|min:6|confirmed',
            'name' => 'nullable|string|max:255',
        ], [
            'registration_id.required' => '登録コードを入力してください',
            'registration_id.unique' => '登録コードは既に使用されています',
            'registration_id.size' => '登録コードは8文字でなければなりません',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => '無効なメールアドレスです',
            'email.unique' => 'そのメールアドレスは既に使用されています',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードは6文字以上でなければなりません',
            'password.confirmed' => 'パスワードの確認が一致しません',
        ]);

        try {
            $admin = Admin::create([
                'registration_id' => $validated['registration_id'],
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $admin->notify(new VerifyEmailCustom($admin));

            return redirect()->route('admin.register')->with('success', '登録が成功しました。メールをご確認ください');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => '登録中にエラーが発生しました: ' . $e->getMessage()])->withInput();
        }
    }

    public function verifyEmail(Request $request, $id, $hash)
    {
        $admin = Admin::findOrFail($id);
    
        if (!hash_equals((string) $hash, sha1($admin->getEmailForVerification()))) {
            abort(403, '無効な確認URLです');
        }
    
        if ($admin->hasVerifiedEmail()) {
            return redirect()->route('admin.login')->with('info', 'そのメールアドレスは既に確認されています');
        }
    
        $admin->markEmailAsVerified();
        event(new Verified($admin));
    
        return redirect()->route('admin.login')->with('success', 'メールアドレスの確認が成功しました');
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
            'registration_id.required' => '登録コードを入力してください',
            'registration_id.size' => '登録コードは8文字でなければなりません',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードは6文字以上でなければなりません',
        ]);
    
        if (Auth::guard('admin')->attempt($validated, $request->filled('remember'))) {
            $user = Auth::guard('admin')->user();
    
            if (is_null($user->email_verified_at)) {
                Auth::guard('admin')->logout();
                return back()->withErrors([
                    'registration_id' => 'あなたのアカウントはまだメール確認が完了していません。確認のためにメールをご確認ください',
                ])->withInput($request->only('registration_id', 'remember'));
            }
    
            return redirect()->route('admin.dashboard')->with('success', 'ログインに成功しました！');
        }

        return back()->withErrors([
            'registration_id' => '登録コードまたはパスワードが正しくありません',
        ])->withInput($request->only('registration_id', 'remember'));
    }    
}
