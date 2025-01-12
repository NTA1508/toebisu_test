<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {

        if (auth()->check()) {
            $user = auth()->user();
            if ($user->role == 'admin' && Admin::where('registration_id', $user->registration_id)->exists()) {
                return $next($request);
            }
        }
        return redirect()->route('admin.login');
    }

}

