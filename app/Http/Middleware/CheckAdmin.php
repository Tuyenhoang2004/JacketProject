<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra nếu người dùng không phải admin, chuyển hướng tới trang user
        if (Auth::check() && Auth::user()->role !== 'admin') {
            return redirect('/'); // Bạn có thể thay bằng trang giao diện người dùng
        }

        return $next($request);
    }
}
