<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email', // Sửa lại 'email' thay vì 'UserEmail'
            'password' => 'required',
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Sửa 'UserEmail' thành 'email'
        $user = \App\Models\User::where('email', $this->email)->first(); // Đổi 'UserEmail' thành 'email'

        if (!$user || !\Hash::check($this->password, $user->password)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('Thông tin đăng nhập không chính xác.'),
            ]);
        }

        Auth::login($user, $this->boolean('remember'));

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [ // Đổi 'UserEmail' thành 'email'
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey()
    {
        return Str::lower($this->input('email')) . '|' . $this->ip(); // Đổi 'UserEmail' thành 'email'
    }
}
