<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <!-- Logo nếu cần -->
        </x-slot>

        <h1 style="text-align: center; font-size: 28px; font-weight: bold;">LẤY LẠI MẬT KHẨU</h1>
        
        <div class="mb-4 text-sm text-gray-600">
            {{ __('Quên mật khẩu? Không sao đâu. Chỉ cần cho chúng tôi biết địa chỉ email của bạn, và chúng tôi sẽ gửi cho bạn một liên kết đặt lại mật khẩu qua email để bạn có thể chọn một mật khẩu mới.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div>
        <x-label for="email" :value="__('Email')" />
        <x-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email') }}" required autofocus />
        
        @error('email')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>
    dd($request->email);


    <div class="flex items-center justify-end mt-4">
        <x-button>
            {{ __('Email Password Reset Link') }}
        </x-button>
    </div>
</form>

    </x-auth-card>
</x-guest-layout>
