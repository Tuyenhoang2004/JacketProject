<x-guest-layout>
<div class="min-h-screen relative flex items-center justify-center bg-cover bg-center">


        
        <!-- Overlay đen mờ -->
        <div class="absolute inset-0 bg-black opacity-50 z-0"></div>

        <!-- Form đăng nhập nổi bật -->
        <div class="relative z-10 w-full max-w-md bg-white bg-opacity-90 p-8 rounded-lg shadow-lg">
            <x-auth-card class="bg-transparent p-0 shadow-none">
                <x-slot name="logo">
                    <!-- Logo (tuỳ thêm sau) -->
                </x-slot>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />
                @if (session('warning'))
                    <div class="mb-4 px-4 py-3 rounded bg-yellow-100 text-yellow-800 text-sm font-medium">
                        {{ session('warning') }}
                    </div>
                @endif

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <h1 style="text-align: center; font-size: 28px; font-weight: bold;">ĐĂNG NHẬP</h1>

                    <!-- Email Address -->
                    <div>
                        <x-label for="email" :value="__('Email')" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-label for="password" :value="__('Password')" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    </div>

                    <!-- Remember Me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <x-button class="ml-3">
                            {{ __('Log in') }}
                        </x-button>
                    </div>
                </form>

                 <!-- Dòng đăng ký -->
                 <div class="mt-4 text-center">
                    <span class="text-sm text-gray-600">Bạn chưa có tài khoản?</span>
                    <a href="{{ route('register') }}" class="underline text-sm text-indigo-600 hover:text-indigo-800">
                        {{ __('Đăng ký ngay') }}
                    </a>
                </div>
            </x-auth-card>
        </div>
    </div>
</x-guest-layout>
