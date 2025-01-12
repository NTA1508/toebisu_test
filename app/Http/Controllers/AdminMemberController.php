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
            'registration_id' => 'required|unique:admins,registration_id|unique:customers,registration_id|size:8',
            'email' => 'required|email|unique:admins,email|unique:customers,email',
            'password' => 'required|min:6',
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
        ]);

        Admin::create([
            'registration_id' => $request->registration_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.member.index')->with('success', '管理者が正常に作成されました');
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
            'registration_id' => 'nullable|size:8|unique:admins,registration_id,' . $admin->id . '|unique:customers,registration_id,' . $admin->id,
            'name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id . '|unique:customers,email,' . $admin->id,
            'password' => 'nullable|min:6',
        ]);
        

        $admin->update([
            'registration_id' => $request->registration_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $admin->password,
        ]);

        return redirect()->route('admin.member.index')->with('success', '管理者情報が更新されました');
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

    public function destroy($id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return redirect()->route('admin.member.index')->with('error', '管理者が見つかりません！');
        }
        $admin->delete();
        return redirect()->route('admin.member.index')->with('success', '管理者が正常に削除されました');
    }
}

