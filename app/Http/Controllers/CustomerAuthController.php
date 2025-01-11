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

        /**
     * Show the registration form.
     */
    public function showRegisterForm()
    {
        $countries = ['Vietnam', 'USA', 'Japan', 'France', 'Germany'];
        $hobbies = ['Reading', 'Traveling', 'Sports', 'Music', 'Movies'];
        return view('customer.register', compact('countries', 'hobbies'));
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'registration_id' => 'required|unique:admins,registration_id|unique:customers,registration_id|size:8',
            'email' => 'required|email|unique:admins,email|unique:customers,email',
            'name' => 'nullable|string|max:255',
            'password' => 'nullable|min:6',
            'gender' => 'nullable|in:male,female',
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
    
        return redirect()->route('customer.register')->with('success', 'Đăng ký thành công!');
    }

    public function verifyEmail(Request $request, $id, $hash)
    {
        $customer = Customer::findOrFail($id);
    
        if (!hash_equals((string) $hash, sha1($customer->getEmailForVerification()))) {
            abort(403, 'URL xác minh không hợp lệ.');
        }
    
        if ($customer->hasVerifiedEmail()) {
            return redirect()->route('customer.login')->with('info', 'Email đã được xác minh trước đó.');
        }
    
        $customer->markEmailAsVerified();
        event(new Verified($customer));
    
        return redirect()->route('customer.login')->with('success', 'Email đã được xác minh thành công.');
    }
}
