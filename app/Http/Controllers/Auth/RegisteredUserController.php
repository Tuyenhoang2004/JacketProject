<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;

class RegisteredUserController extends Controller
{
    /**
     * Hiển thị trang đăng ký.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Xử lý yêu cầu đăng ký người dùng.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], // ✅ Đã sửa từ UserEmail -> email
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'UserPhone' => ['nullable', 'string', 'max:15'],
        'UserAddress' => ['nullable', 'string', 'max:128'],
    ]);

    // Tạo người dùng mới
    $user = User::create([
        'UserName' => $request->name,
        'email' => $request->email, // ✅ Cột mới trong DB là 'email'
        'UserPassword' => Hash::make($request->password),
        'UserPhone' => $request->UserPhone ?? null,
        'UserAddress' => $request->UserAddress ?? null,
    ]);

    // Đăng nhập người dùng
    Auth::login($user);

    return redirect()->route('home');
}

}
