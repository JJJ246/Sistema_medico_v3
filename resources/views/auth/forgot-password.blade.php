<x-guest-layout>
    <x-slot name="title">Forgot Password - Salud Conectada</x-slot>

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
        <!-- Medical Shield Icon -->
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center">
                <svg class="w-12 h-12 text-primary-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
        </div>

        <!-- Header -->
        <div class="text-center mb-8">
            <p class="text-gray-600 text-base">
                Enter your registered email to receive a secure recovery link.
            </p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm text-center">
                {{ session('status') }}
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="input-field @error('email') border-red-500 @enderror"
                       placeholder="your.email@example.com">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-gradient-to text-white font-semibold py-3 px-8 rounded-full hover:shadow-xl transition-all duration-300 shadow-lg mb-6">
                Send Reset Link
            </button>

            <!-- Back to Login Link -->
            <a href="{{ route('login') }}" class="block text-center text-gray-500 text-sm hover:text-gray-700 transition-colors">
                Back to Login
            </a>
        </form>
    </div>
</x-guest-layout>
