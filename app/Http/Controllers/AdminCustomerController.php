<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class AdminCustomerController extends Controller
{
    //Add Customer
    public function create()
    {
        $countries = ['Vietnam', 'USA', 'Japan', 'France', 'Germany'];
        $hobbies = ['Reading', 'Traveling', 'Sports', 'Music', 'Movies'];
        return view('admin.customer.create', compact('countries', 'hobbies'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'registration_id' => 'nullable|unique:customers,registration_id|size:8',
            'name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:customers,email',
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
    
        Customer::create($validatedData);
    
        return redirect()->route('admin.customer.index')->with('success', 'Khách hàng đã được thêm thành công!');
    }

    //Edit Customer
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $countries = ['Vietnam', 'USA', 'Japan', 'France', 'Germany'];
        $hobbies = ['Reading', 'Traveling', 'Sports', 'Music', 'Movies'];
        $selectedHobbies = $customer->hobbies ? json_decode($customer->hobbies, true) : []; // Chuyển đổi lại sở thích thành mảng
        return view('admin.customer.edit', compact('customer', 'countries', 'hobbies', 'selectedHobbies'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $validatedData = $request->validate([
            'registration_id' => 'nullable|size:8|unique:customers,registration_id,' . $customer->id,
            'password' => 'nullable|min:6',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'name' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'hobbies' => 'nullable|array',
            'country' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $validatedData['hobbies'] = $request->hobbies ? json_encode($request->hobbies) : null;

        if ($request->hasFile('profile_picture')) {
            if ($customer->profile_picture) {
                Storage::disk('public')->delete($customer->profile_picture);
            }
            $validatedData['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $customer->update($validatedData);

        return redirect()->route('admin.customer.index')->with('success', 'Thông tin khách hàng đã được cập nhật!');
    }

    // Get all Customer
    public function index(Request $request)
    {
        $search = $request->input('search');

        $customers = Customer::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                     ->orWhere('email', 'like', "%{$search}%")
                     ->orWhere('registration_id', 'like', "%{$search}%");
        })->paginate(10);

        return view('admin.customer.index', compact('customers', 'search'));
    }

    //Export CSV file
    public function exportCsv()
    {
        $customers = Customer::all();
        $csvData = "ID,Registration ID,Name,Email,Created At,Gender,Hobbies,Country\n";
    
        foreach ($customers as $customer) {
            $hobbies = $customer->hobbies ? implode(', ', json_decode($customer->hobbies)) : 'No hobbies';
            $csvData .= "{$customer->id},\"{$customer->registration_id}\", \"{$customer->name}\",\"{$customer->email}\",{$customer->created_at},{$customer->gender},\"{$hobbies}\",{$customer->country}\n";
        }
    
        $fileName = 'customers_' . now()->format('Ymd_His') . '.csv';
    
        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename={$fileName}");
    }
}
