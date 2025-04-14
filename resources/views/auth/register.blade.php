<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
    @csrf
    <h1 style="text-align: center; font-size: 28px; font-weight: bold;">ĐĂNG KÝ</h1>
    <!-- Name -->
    <div>
        <x-label for="name" :value="__('Name')" />
        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
    </div>

    <!-- UserEmail -->
    <div class="mt-4">
        <x-label for="UserEmail" :value="__('Email')" />
        <x-input id="UserEmail" class="block mt-1 w-full" type="email" name="UserEmail" :value="old('UserEmail')" required />
    </div>

    <!-- Password -->
    <div class="mt-4">
        <x-label for="password" :value="__('Password')" />
        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
    </div>

    <!-- Confirm Password -->
    <div class="mt-4">
        <x-label for="password_confirmation" :value="__('Confirm Password')" />
        <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
    </div>

    <!-- UserPhone (Không bắt buộc) -->
    <div class="mt-4">
        <x-label for="UserPhone" :value="__('Phone')" />
        <x-input id="UserPhone" class="block mt-1 w-full" type="text" name="UserPhone" :value="old('UserPhone')" />
    </div>

    <!-- UserAddress (Không bắt buộc) -->
    <div class="mt-4">
        <x-label for="UserAddress" :value="__('Address')" />
        <x-input id="UserAddress" class="block mt-1 w-full" type="text" name="UserAddress" :value="old('UserAddress')" />
    </div>

    <div class="flex items-center justify-end mt-4">
        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
            {{ __('Already registered?') }}
        </a>

        <x-button class="ml-4">
            {{ __('Register') }}
        </x-button>
    </div>
</form>

    </x-auth-card>
</x-guest-layout>
