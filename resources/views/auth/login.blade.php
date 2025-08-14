<x-guest-layout>
    {{-- Page Title --}}
    <h2 class="text-3xl font-bold text-tm-dark-blue mb-2">Login to your Account</h2>
    <p class="text-gray-500 mb-8">Welcome back! Please enter your details.</p>

    {{-- Session Status --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- Login Form --}}
    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email Address --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Remember Me & Forgot Password --}}
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-tm-cyan shadow-sm focus:ring-tm-cyan" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-tm-cyan hover:text-tm-dark-blue rounded-md focus:outline-none"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        {{-- Login Button --}}
        <div class="mt-6">
            <button type="submit"
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-tm-cyan hover:bg-tm-dark-blue focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-tm-cyan">
                {{ __('Log in') }}
            </button>
        </div>
    </form>

    {{-- ▼▼▼ هذا هو الكود الجديد الذي تمت إضافته ▼▼▼ --}}

    <!-- Divider with "OR" -->
    <div class="my-6 flex items-center">
        <div class="flex-grow border-t border-gray-300"></div>
        <span class="mx-4 text-sm text-gray-500 font-semibold">OR</span>
        <div class="flex-grow border-t border-gray-300"></div>
    </div>

    <!-- Social Login Buttons -->
    <div class="space-y-3">
        {{-- Google Button --}}
        <a href="{{ route('socialite.redirect', 'google') }}"
            class="w-full flex items-center justify-center px-4 py-2.5 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
            <img class="w-5 h-5 me-3" src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google icon">
            <span>Continue with Google</span>
        </a>
    </div>

    <!-- Sign up Link -->
    <div class="mt-8 text-center">
        <p class="text-sm text-gray-600">
            Don't have an account?
            <a href="{{ route('register') }}" class="font-medium text-tm-cyan hover:text-tm-dark-blue underline">
                Sign up
            </a>
        </p>
    </div>

    {{-- ▲▲▲ نهاية الكود المضاف ▲▲▲ --}}

</x-guest-layout>
