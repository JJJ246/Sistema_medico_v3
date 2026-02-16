<x-guest-layout>
    <x-slot name="title">Create Account - Step 2</x-slot>

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
        <!-- Progress Bar -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-gray-600 font-medium">Step 2 of 2</span>
            </div>
            <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                <div class="h-full bg-medical-green w-full transition-all duration-300"></div>
            </div>
        </div>

        <!-- Header -->
        <div class="mb-8">
            <p class="text-sm text-gray-500 mb-2">Health Profile</p>
            <h2 class="text-3xl font-bold text-gray-900">Complete Your Profile</h2>
            <p class="text-sm text-gray-600 mt-2">You're almost there! Your account is ready to be created.</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('register.step2.store') }}">
            @csrf

            <div class="mb-6 text-center py-8 bg-green-50 rounded-lg">
                <svg class="w-16 h-16 text-medical-green mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Account Information Verified</h3>
                <p class="text-sm text-gray-600">Click below to complete your registration</p>
            </div>

            <!-- Information Display -->
            @if(session('registration_step1'))
            <div class="mb-6 bg-gray-50 rounded-lg p-4 space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Name:</span>
                    <span class="font-medium text-gray-900">{{ session('registration_step1')['full_name'] }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Email:</span>
                    <span class="font-medium text-gray-900">{{ session('registration_step1')['email'] }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Birthdate:</span>
                    <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse(session('registration_step1')['birthdate'])->format('F d, Y') }}</span>
                </div>
            </div>
            @endif

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-medical-green text-white font-semibold py-3 px-8 rounded-lg hover:bg-emerald-600 transition-all duration-300 shadow-md hover:shadow-lg mb-4">
                Create Account
            </button>

            <a href="{{ route('register.step1') }}" class="block w-full text-center text-gray-600 font-medium hover:text-gray-900 transition-colors">
                Back to Step 1
            </a>
        </form>
    </div>
</x-guest-layout>
