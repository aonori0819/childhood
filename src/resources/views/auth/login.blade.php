<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <img src="/images/teddybear_small.svg">
            <p>childhood</p>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <input type="hidden" name="remember" id="remember-me" value="on">

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <div class="container">
                <div class="row mt-4">
                    <x-button class="">
                        {{ __('Log in') }}
                    </x-button>
                </div>
            </div>

            <div class="container">
                <div class="row mt-5">
                        または　<a href="{{ route('register') }}">新規登録</a>
                </div>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
