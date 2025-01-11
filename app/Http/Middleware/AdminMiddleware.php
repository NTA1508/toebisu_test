<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminMiddleware
{
public function handle(Request $request, Closure $next)
{
    // Kiểm tra nếu người dùng đã đăng nhập và là admin
    if (auth()->check()) {
        $user = auth()->user();
        
        // Kiểm tra nếu người dùng có trong bảng admins và có vai trò admin
        if ($user->role == 'admin' && Admin::where('registration_id', $user->registration_id)->exists()) {
            return $next($request);
        }
    }

    // Nếu không phải admin hoặc người dùng không tồn tại trong bảng admins, chuyển hướng về trang đăng nhập
    return redirect()->route('admin.login');
}

}

