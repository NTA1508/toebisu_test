<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Auth\Events\Verified;

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
            'registration_id.required' => '登録コードを入力してください',
            'registration_id.size' => '登録コードは8文字でなければなりません',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードは6文字以上でなければなりません',
        ]);

        if (Auth::guard('web')->attempt($request->only('registration_id', 'password'), $request->filled('remember'))) {
            return redirect()->route('customer.profile')->with('success', 'ログインに成功しました！');
        }

        return back()->withErrors([
            'registration_id' => '登録コードまたはパスワードが正しくありません',
        ])->withInput($request->only('registration_id', 'remember'));
    }

        /**
     * Show the registration form.
     */
    public function showRegisterForm()
    {
        $countries = ['ベトナム', 'アメリカ', '日本', 'フランス', 'ドイツ'];
        $hobbies = ['読書', '旅行', 'スポーツ', '音楽', '映画'];   
        return view('customer.register', compact('countries', 'hobbies'));
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'registration_id' => 'required|unique:admins,registration_id|unique:customers,registration_id|size:8',
            'email' => 'required|email|unique:admins,email|unique:customers,email',
            'name' => 'nullable|string|max:255',
            'password' => 'nullable|min:6',
            'gender' => 'nullable|in:男,女',
            'hobbies' => 'nullable|array',
            'country' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', 
        ]);

        $validatedData['hobbies'] = $request->hobbies ? json_encode($request->hobbies) : null;

        if ($request->hasFile('profile_picture')) {
            $validatedData['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }
    
        $customer = Customer::create($validatedData);

        $customer->sendEmailVerificationNotification();
    
        return redirect()->route('customer.register')->with('success', '登録が成功しました。メールをご確認ください!');
    }

    public function verifyEmail(Request $request, $id, $hash)
    {
        $customer = Customer::findOrFail($id);
    
        if (!hash_equals((string) $hash, sha1($customer->getEmailForVerification()))) {
            abort(403, '無効な確認URLです');
        }
    
        if ($customer->hasVerifiedEmail()) {
            return redirect()->route('customer.login')->with('info', 'そのメールアドレスは既に確認されています');
        }
    
        $customer->markEmailAsVerified();
        event(new Verified($customer));
    
        return redirect()->route('customer.login')->with('success', 'メールアドレスの確認が成功しました');
    }
}
