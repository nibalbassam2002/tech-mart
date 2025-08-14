<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />
    <link rel="icon" href="{{ asset('images/logo21-removebg-preview.png') }}" type="image/png">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen w-full flex bg-gray-100">

        <!-- ===== Left Side (Login Form) ===== -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-8 bg-white"
            style="clip-path: path('M 0,0 L 1000,0 L 1000,0 C 950,400 1050,600 1000,1000 L 0,1000 Z');">

            <div class="w-full max-w-md">
                {{-- Logo for small screens --}}
                <div class="lg:hidden mb-8 text-center">
                    <a href="/">
                        <img src="{{ asset('images/tech-mart.png') }}" alt="Tech Mart Logo" class="w-32 h-auto mx-auto">
                    </a>
                </div>

                {{-- The form content will be injected here --}}
                {{ $slot }}

            </div>
        </div>

        <!-- ===== Right Side (Aesthetic Part) - Updated! ===== -->
        <div class="hidden lg:flex w-1/2 bg-tm-dark-blue items-center justify-center p-12 text-white relative overflow-hidden layered-bg"
            style="background-image: url('data:image/svg+xml,%3csvg width=\'40\' height=\'40\' viewBox=\'0 0 40 40\' xmlns=\'http://www.w3.org/2000/svg\'%3e%3cg fill=\'%2300b4d8\' fill-opacity=\'0.1\'%3e%3cpath d=\'M0 38.59l2.83-2.83 1.41 1.41L1.41 40H0v-1.41zM0 1.4l2.83 2.83 1.41-1.41L1.41 0H0v1.41zM38.59 40l-2.83-2.83 1.41-1.41L40 38.59V40h-1.41zM40 1.41l-2.83 2.83-1.41-1.41L38.59 0H40v1.41zM20 18.6l2.83-2.83 1.41 1.41L21.41 20l2.83 2.83-1.41 1.41L20 21.41l-2.83 2.83-1.41-1.41L18.59 20l-2.83-2.83 1.41-1.41L20 18.59z\'/%3e%3c/g%3e%3c/svg%3e');">
            <div class="text-center z-10">
                {{-- Logo/Illustration --}}
                <img src="{{ asset('images/Login-bro.svg') }}" alt="Tech Mart Illustration"
                    class="w-80 h-auto mx-auto mb-8 drop-shadow-xl">

                {{-- Welcome Text --}}
                <h1 class="text-5xl font-extrabold text-white drop-shadow-lg mb-3">Welcome to Tech-Mart</h1>
                <p class="text-lg text-tm-cyan">Your one-stop shop for the latest electronics</p>
            </div>
        </div>

    </div>
</body>

</html>
