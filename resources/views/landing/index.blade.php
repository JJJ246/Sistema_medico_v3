<x-landing>
    <x-slot name="title">Salud Conectada - Your Health, Our Commitment</x-slot>

    <!-- Hero Section -->
    <section class="py-20 lg:py-28">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Column - Text -->
                <div>
                    <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                        Your Health,<br>
                        <span class="text-primary-blue">Our Commitment</span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-8">
                        Connecting you to better healthcare services, anytime, anywhere. Manage your health journey with ease.
                    </p>
                    <a href="{{ route('register.step1') }}" class="btn-primary inline-block">Get Started</a>
                </div>
                
                <!-- Right Column - Illustration -->
                <div class="hidden lg:block">
                    <img src="{{ asset('images/hero-doctor.png') }}" alt="Healthcare Professional" class="w-full rounded-2xl shadow-2xl">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center text-gray-900 mb-4">Empowering Your Health Journey</h2>
            <p class="text-center text-gray-600 mb-16 max-w-2xl mx-auto">Comprehensive digital health tools designed to simplify your medical management</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1: Digital Pillbox -->
                <div class="card-feature text-center">
                    <div class="w-20 h-20 bg-medical-green/10 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-medical-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Digital Pillbox</h3>
                    <p class="text-gray-600">Never miss a dose. Get timely reminders and manage your medication schedule effortlessly.</p>
                </div>
                
                <!-- Feature 2: Smart Prescriptions -->
                <div class="card-feature text-center">
                    <div class="w-20 h-20 bg-primary-blue/10 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-primary-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Smart Prescriptions</h3>
                    <p class="text-gray-600">Receive and manage digital prescriptions directly from your doctor, ready for pharmacy pick-up.</p>
                </div>
                
                <!-- Feature 3: Lab Results -->
                <div class="card-feature text-center">
                    <div class="w-20 h-20 bg-blue-500/10 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Lab Results</h3>
                    <p class="text-gray-600">Access your laboratory test results securely as soon as they are ready, with clear interpretations.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 bg-bg-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center text-gray-900 mb-16">How It Works</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-primary-blue rounded-full flex items-center justify-center mx-auto mb-6 text-white text-2xl font-bold shadow-lg">
                        1
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Create Your Account</h3>
                    <p class="text-gray-600">Sign up easily and securely with your personal details and health profile.</p>
                </div>
                
                <!-- Step 2 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-primary-blue rounded-full flex items-center justify-center mx-auto mb-6 text-white text-2xl font-bold shadow-lg">
                        2
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Connect with Providers</h3>
                    <p class="text-gray-600">Link with your doctors and healthcare facilities to centralize your medical information.</p>
                </div>
                
                <!-- Step 3 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-primary-blue rounded-full flex items-center justify-center mx-auto mb-6 text-white text-2xl font-bold shadow-lg">
                        3
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Manage Your Health</h3>
                    <p class="text-gray-600">Access tools, track progress, and take charge of your well-being from one platform.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold text-gray-900 mb-6">About Salud Conectada</h2>
            <p class="text-xl text-gray-600 mb-8">
                We are dedicated to transforming healthcare accessibility through innovative digital solutions. Our platform connects patients with their healthcare providers, making medical management simpler, safer, and more efficient.
            </p>
            <p class="text-lg text-gray-600">
                With state-of-the-art security measures and user-friendly design, we ensure your health data is protected while providing you with the tools needed for proactive health management.
            </p>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-bg-light">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold text-gray-900 mb-6">Get in Touch</h2>
            <p class="text-xl text-gray-600 mb-8">Have questions? We're here to help!</p>
            
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <div class="w-12 h-12 bg-medical-green/10 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-medical-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-2">Email</h4>
                        <p class="text-gray-600">support@saludconectada.com</p>
                    </div>
                    
                    <div>
                        <div class="w-12 h-12 bg-primary-blue/10 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-primary-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-2">Phone</h4>
                        <p class="text-gray-600">+1 (555) 123-4567</p>
                    </div>
                    
                    <div>
                        <div class="w-12 h-12 bg-blue-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-2">Address</h4>
                        <p class="text-gray-600">123 Wellness Blvd, Health City</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-landing>
