<x-guest-layout>
    <x-slot name="title">Create Account - Step 1</x-slot>

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
        <!-- Progress Bar -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-gray-600 font-medium">Step 1 of 2</span>
            </div>
            <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                <div class="h-full bg-medical-green w-1/2 transition-all duration-300"></div>
            </div>
        </div>

        <!-- Header -->
        <div class="mb-8">
            <p class="text-sm text-gray-500 mb-2">Account Details</p>
            <h2 class="text-3xl font-bold text-gray-900">Create Your Account</h2>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('register.step1.store') }}">
            @csrf

            <!-- Full Name -->
            <div class="mb-4">
                <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                <input id="full_name" type="text" name="full_name" value="{{ old('full_name') }}" required autofocus autocomplete="name"
                       class="input-field @error('full_name') border-red-500 @enderror">
                @error('full_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                       class="input-field @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Birthdate -->
            <div class="mb-4">
                <label for="birthdate" class="block text-sm font-medium text-gray-700 mb-2">Birthdate</label>
                <input id="birthdate" type="date" name="birthdate" value="{{ old('birthdate') }}" required
                       class="input-field @error('birthdate') border-red-500 @enderror">
                @error('birthdate')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <div class="relative">
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           class="input-field pr-10 @error('password') border-red-500 @enderror">
                    <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
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

            <!-- Password Confirmation -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       class="input-field">
            </div>

            <!-- Security Badge -->
            <div class="mb-6 flex items-center space-x-3 bg-blue-50 p-4 rounded-lg">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-primary-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-primary-blue">Security Shield</p>
                    <p class="text-xs text-gray-600">Your medical data is encrypted and secure</p>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-primary-blue text-white font-semibold py-3 px-8 rounded-lg hover:bg-blue-700 transition-all duration-300 shadow-md hover:shadow-lg">
                Continue to Health Profile
            </button>

            <p class="mt-4 text-center text-sm text-gray-600">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-primary-blue font-semibold hover:underline">Sign In</a>
            </p>
        </form>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            field.type = field.type === 'password' ? 'text' : 'password';
        }
    </script>
</x-guest-layout>
