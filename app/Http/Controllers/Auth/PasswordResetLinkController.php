<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
{
    Log::info('Email input: ' . $request->email);

    $request->validate([
        'email' => ['required', 'email'], // Kiểm tra lại nếu email không hợp lệ
    ]);

    // Gửi liên kết đặt lại mật khẩu
    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status == Password::RESET_LINK_SENT
                ? back()->with('status', __($status))
                : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
}

}
