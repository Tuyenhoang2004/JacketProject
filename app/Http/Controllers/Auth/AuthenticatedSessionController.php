<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
{
    // Kiểm tra xem người dùng có tồn tại không
    $user = User::where('email', $request->email)->first();

    if ($user) {
        // Kiểm tra xem mật khẩu có khớp không
        if (Hash::check($request->password, $user->password)) {
            // Nếu mật khẩu đúng, thực hiện đăng nhập
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
                $request->session()->regenerate();

                // Kiểm tra vai trò của người dùng
                if (Auth::user()->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                } else {
                    return redirect('/');
                }
            }
        } else {
            // Mật khẩu sai
            return back()->withErrors(['password' => 'Mật khẩu không đúng.']);
        }
    } else {
        // Email không tồn tại trong cơ sở dữ liệu
        return back()->withErrors(['email' => 'Email không tồn tại.']);
    }

    // Nếu không thỏa mãn cả hai điều kiện trên, thông báo lỗi chung
    return back()->withErrors(['email' => 'Thông tin đăng nhập không đúng.']);
}


    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        // Xóa thông tin khỏi session
        $request->session()->forget(['UserName', 'UserPhone']);

        return redirect('/');
    }
}
