<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerProfileController extends Controller
{
    public function show()
    {
        $customer = Auth::user();
        return view('customer.profile', compact('customer'));
    }

    public function edit()
    {
        $customer = Auth::user();
        $countries = ['ベトナム', 'アメリカ', '日本', 'フランス', 'ドイツ'];
        $hobbies = ['読書', '旅行', 'スポーツ', '音楽', '映画'];   
        $selectedHobbies = $customer->hobbies ? json_decode($customer->hobbies, true) : [];
        
        return view('customer.edit', compact('customer', 'countries', 'hobbies', 'selectedHobbies'));
    }

    public function update(Request $request)
    {
        $customer = Auth::user();

        $validatedData = $request->validate([
            'registration_id' => 'nullable|size:8|unique:customers,registration_id,' . $customer->id . '|unique:admins,registration_id,' . $customer->id,
            'password' => 'nullable|min:6',
            'email' => 'required|email|unique:customers,email,' . $customer->id . '|unique:admins,email,' . $customer->id,
            'name' => 'nullable|string|max:255',
            'gender' => 'nullable|in:男,女',
            'hobbies' => 'nullable|array',
            'country' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $validatedData['hobbies'] = $request->hobbies ? json_encode($request->hobbies) : null;

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validatedData['profile_picture'] = $path;
        }

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $customer->update($validatedData);

        return redirect()->route('customer.profile')->with('success', 'あなたの情報は更新されました！');
    }
}
