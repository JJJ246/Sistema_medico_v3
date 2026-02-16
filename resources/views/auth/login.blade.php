<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Sign In - Salud Conectada' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bg-light antialiased">
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
        <!-- Left Column - Illustration -->
        <div class="hidden lg:flex bg-gradient-to-br from-blue-gradient-from to-blue-gradient-to items-center justify-center p-12 relative overflow-hidden">
            <div class="absolute inset-0 bg-black opacity-5"></div>
            <div class="relative z-10 text-center">
                <img src="{{ asset('images/login-doctor.png') }}" alt="Medical Professional" class="w-96 mx-auto mb-8 drop-shadow-2xl">
                <h2 class="text-4xl lg:text-5xl font-bold text-white mb-4 leading-tight">
                    Trust, Health,<br>
                    and Digital Care
                </h2>
                <p class="text-xl text-white/90">Your health journey starts here</p>
            </div>
        </div>

        <!-- Right Column - Login Form -->
        <div class="flex items-center justify-center p-8 lg:p-12">
            <div class="w-full max-w-md">
                <!-- Logo for mobile -->
                <div class="lg:hidden flex items-center justify-center mb-8">
                    <img src="{{ asset('images/logo-shield.png') }}" alt="Logo" class="h-12 w-12">
                    <span class="ml-3 text-2xl font-bold text-gray-900">Salud Conectada</span>
                </div>

                <div class="bg-white rounded-2xl shadow-xl p-8 lg:p-10">
                    <h2 class="text-3xl font-bold text-primary-blue mb-8 text-center">Sign In</h2>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                   class="input-field @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <div class="relative">
                                <input id="password" type="password" name="password" required autocomplete="current-password"
                                       class="input-field pr-10 @error('password') border-red-500 @enderror">
                                <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember" class="rounded border-gray-300 text-primary-blue focus:ring-primary-blue">
                                <span class="ml-2 text-sm text-gray-600">Remember me</span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-medical-green text-white font-semibold py-3 px-8 rounded-lg hover:bg-emerald-600 transition-all duration-300 shadow-md hover:shadow-lg mb-4">
                            Sign In
                        </button>

                        <!-- Links -->
                        <div class="text-center space-y-2">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="block text-sm text-primary-blue hover:underline font-medium">
                                    Forgot Password?
                                </a>
                            @endif
                            <p class="text-sm text-gray-600">
                                Don't have an account? 
                                <a href="{{ route('register.step1') }}" class="text-primary-blue font-semibold hover:underline">Create an Account</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const field = document.getElementById('password');
            field.type = field.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>
