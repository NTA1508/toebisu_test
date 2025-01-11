<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminMemberController extends Controller
{

    //Create Member
    public function create()
    {
        return view('admin.member.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'registration_id' => 'required|unique:admins,registration_id|size:8',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6',
            'name' => 'nullable|string|max:255',
        ], [
            'registration_id.required' => 'Vui lòng nhập mã đăng ký.',
            'registration_id.unique' => 'Mã đăng ký đã được sử dụng.',
            'registration_id.size' => 'Mã đăng ký phải có độ dài 8 ký tự.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ]);

        Admin::create([
            'registration_id' => $request->registration_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.member.index')->with('success', 'Quản trị viên được tạo thành công.');
    }

    //Edit member
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return view('admin.member.edit', compact('admin'));
    }
    
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $request->validate([
            'registration_id' => 'nullable|size:8|unique:admins,registration_id,' . $admin->id,
            'name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'password' => 'nullable|min:6',
        ]);
        

        $admin->update([
            'registration_id' => $request->registration_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $admin->password,
        ]);

        return redirect()->route('admin.member.index')->with('success', 'Thông tin quản trị viên đã được cập nhật.');
    }

    // Get all member
    public function index(Request $request)
    {
        $search = $request->input('search');

        $admins = Admin::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                     ->orWhere('email', 'like', "%{$search}%")
                     ->orWhere('registration_id', 'like', "%{$search}%");
        })->paginate(10);

        return view('admin.member.index', compact('admins', 'search'));
    }

    //Export CSV file
    public function exportCsv()
    {
        $admins = Admin::all();
        $csvData = "ID,Registration_id, Name,Email,Created At\n";

        foreach ($admins as $admin) {
            $csvData .= "{$admin->id},\"{$admin->registration_id}\", \"{$admin->name}\",\"{$admin->email}\",{$admin->created_at}\n";
        }

        $fileName = 'members_' . now()->format('Ymd_His') . '.csv';

        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename={$fileName}");
    }
}

