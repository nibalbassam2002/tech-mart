<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('images/logo21-removebg-preview.png') }}" type="image/png">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen w-full flex bg-gray-100">

        <!-- ===== Left Side (FORM GOES HERE) ===== -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-8 bg-white"
            style="clip-path: path('M 0,0 L 1000,0 L 1000,0 C 950,400 1050,600 1000,1000 L 0,1000 Z');">
            <div class="w-full max-w-md">
                {{-- Logo for small screens --}}
                <div class="lg:hidden mb-8 text-center">
                    <a href="/">
                        <img src="{{ asset('images/logo21.png') }}" alt="Tech Mart Logo" class="w-32 h-auto mx-auto">
                    </a>
                </div>

                {{-- ▼▼▼ هذا هو نموذج التسجيل الخاص بك ▼▼▼ --}}
                <h2 class="text-3xl font-bold text-tm-dark-blue mb-2">Create your Account</h2>
                <p class="text-gray-500 mb-8">Join us to start your shopping journey!</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" class="text-sm font-medium" />
                        <x-text-input id="name" class="block mt-1 w-full text-base" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" class="text-sm font-medium" />
                        <x-text-input id="email" class="block mt-1 w-full text-base" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" class="text-sm font-medium" />
                        <x-text-input id="password" class="block mt-1 w-full text-base" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm font-medium" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full text-base" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>
                        <x-primary-button class="ms-4 bg-tm-cyan hover:bg-tm-dark-blue">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>

                    <!-- Divider with "OR" -->
                    <div class="my-6 flex items-center">
                        <div class="flex-grow border-t border-gray-300"></div>
                        <span class="mx-4 text-sm text-gray-500 font-semibold">OR</span>
                        <div class="flex-grow border-t border-gray-300"></div>
                    </div>

                    <!-- Social Login Buttons -->
                    <a href="{{ route('socialite.redirect', 'google') }}"
                        class="w-full flex items-center justify-center px-4 py-2.5 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <img class="w-5 h-5 me-3" src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google icon">
                        <span>Sign up with Google</span>
                    </a>
                </form>
                {{-- ▲▲▲ نهاية نموذج التسجيل ▲▲▲ --}}

            </div>
        </div>

        <!-- ===== Right Side (CUSTOMIZED FOR REGISTER PAGE) ===== -->
        <div class="hidden lg:flex w-1/2 bg-tm-dark-blue items-center justify-center p-12 text-white relative overflow-hidden layered-bg"
            style="background-image: url('data:image/svg+xml,%3csvg width=\'40\' height=\'40\' viewBox=\'0 0 40 40\' xmlns=\'http://www.w3.org/2000/svg\'%3e%3cg fill=\'%2300b4d8\' fill-opacity=\'0.1\'%3e%3cpath d=\'M0 38.59l2.83-2.83 1.41 1.41L1.41 40H0v-1.41zM0 1.4l2.83 2.83 1.41-1.41L1.41 0H0v1.41zM38.59 40l-2.83-2.83 1.41-1.41L40 38.59V40h-1.41zM40 1.41l-2.83 2.83-1.41-1.41L38.59 0H40v1.41zM20 18.6l2.83-2.83 1.41 1.41L21.41 20l2.83 2.83-1.41 1.41L20 21.41l-2.83 2.83-1.41-1.41L18.59 20l-2.83-2.83 1.41-1.41L20 18.59z\'/%3e%3c/g%3e%3c/svg%3e');">
            <div class="text-center z-10">
                {{-- ▼▼▼ هنا الصورة الجديدة الخاصة بصفحة التسجيل ▼▼▼ --}}
                <img src="{{ asset('images/sign up.svg') }}" alt="Create Account Illustration"
                    class="w-80 h-auto mx-auto mb-8 drop-shadow-xl">

                {{-- ▼▼▼ هنا النص الجديد الخاص بصفحة التسجيل ▼▼▼ --}}
                <h1 class="text-5xl font-extrabold text-white drop-shadow-lg mb-3">Join Our Community</h1>
                <p class="text-lg text-tm-cyan">Create an account to unlock exclusive features</p>
            </div>
        </div>

    </div>
</body>
</html>