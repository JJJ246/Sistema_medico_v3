<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Salud Conectada') }} - @yield('title', 'Dashboard')</title>
    
    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#10b77f",
                        "primary-dark": "#059669",
                        "background-light": "#f1f5f9",
                        "background-dark": "#0f172a",
                        "surface-light": "#ffffff",
                        "surface-dark": "#1e293b",
                        "med-blue": "#2563eb",
                        "med-blue-dark": "#1e40af",
                        "contrast-text": "#0f172a"
                    },
                    fontFamily: {
                        "display": ["Manrope", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.5rem",
                        "lg": "1rem",
                        "xl": "1.5rem",
                        "2xl": "2rem", 
                        "3xl": "2.5rem",
                        "full": "9999px"
                    },
                    boxShadow: {
                        "soft": "0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)",
                        "xl": "0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)",
                        "glow": "0 0 20px rgba(37, 99, 235, 0.2)"
                    }
                },
            },
        }
    </script>
    <style>
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #e2e8f0;
        }
        ::-webkit-scrollbar-thumb {
            background-color: #94a3b8;
            border-radius: 20px;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-50 min-h-screen flex transition-colors duration-300">
    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 w-20 lg:w-72 bg-med-blue dark:bg-slate-900 shadow-xl z-50 flex flex-col justify-between transition-all duration-300">
        <div class="p-6 flex items-center gap-3 border-b border-white/10">
            <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center shrink-0 shadow-lg">
                <span class="material-icons-outlined text-med-blue text-3xl">local_pharmacy</span>
            </div>
            <span class="text-2xl font-extrabold tracking-tight text-white hidden lg:block">
                Salud<span class="text-green-300">Conectada</span>
            </span>
        </div>
        
        <nav class="flex-1 px-4 space-y-3 mt-8">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-4 py-4 rounded-2xl transition-all group font-medium {{ request()->routeIs('dashboard') ? 'bg-white text-med-blue font-bold shadow-lg translate-x-2' : 'hover:bg-white/10 text-white/90 hover:text-white' }}">
                <span class="material-icons-outlined text-2xl {{ request()->routeIs('dashboard') ? '' : 'group-hover:scale-110 transition-transform' }}">dashboard</span>
                <span class="hidden lg:block text-lg">Inicio</span>
            </a>
            
            <a href="{{ route('medications.index') }}" class="flex items-center gap-4 px-4 py-4 rounded-2xl transition-all group font-medium {{ request()->routeIs('medications.*') ? 'bg-white text-med-blue font-bold shadow-lg translate-x-2' : 'hover:bg-white/10 text-white/90 hover:text-white' }}">
                <span class="material-icons-outlined text-2xl {{ request()->routeIs('medications.*') ? '' : 'group-hover:scale-110 transition-transform' }}">medication</span>
                <span class="hidden lg:block text-lg">Mis Medicamentos</span>
            </a>
            
            <a href="{{ route('schedule.index') }}" class="flex items-center gap-4 px-4 py-4 rounded-2xl transition-all group font-medium {{ request()->routeIs('schedule.*') ? 'bg-white text-med-blue font-bold shadow-lg translate-x-2' : 'hover:bg-white/10 text-white/90 hover:text-white' }}">
                <span class="material-icons-outlined text-2xl {{ request()->routeIs('schedule.*') ? '' : 'group-hover:scale-110 transition-transform' }}">calendar_month</span>
                <span class="hidden lg:block text-lg">Horario</span>
            </a>
            
            <a href="{{ route('doctors.index') }}" class="flex items-center gap-4 px-4 py-4 rounded-2xl transition-all group font-medium {{ request()->routeIs('doctors.*') ? 'bg-white text-med-blue font-bold shadow-lg translate-x-2' : 'hover:bg-white/10 text-white/90 hover:text-white' }}">
                <span class="material-icons-outlined text-2xl {{ request()->routeIs('doctors.*') ? '' : 'group-hover:scale-110 transition-transform' }}">medical_services</span>
                <span class="hidden lg:block text-lg">Doctores</span>
            </a>
            
            <a href="{{ route('prescriptions.index') }}" class="flex items-center gap-4 px-4 py-4 rounded-2xl transition-all group font-medium {{ request()->routeIs('prescriptions.*') ? 'bg-white text-med-blue font-bold shadow-lg translate-x-2' : 'hover:bg-white/10 text-white/90 hover:text-white' }}">
                <span class="material-icons-outlined text-2xl {{ request()->routeIs('prescriptions.*') ? '' : 'group-hover:scale-110 transition-transform' }}">history</span>
                <span class="hidden lg:block text-lg">Historial Recetas</span>
            </a>
        </nav>
        
        <div class="p-4 mt-auto">
            <div class="flex items-center gap-3 p-3 rounded-2xl bg-med-blue-dark border border-white/10 cursor-pointer hover:bg-black/20 transition-colors shadow-lg">
                <img class="w-12 h-12 rounded-full object-cover border-2 border-white" src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}">
                <div class="hidden lg:block overflow-hidden">
                    <p class="text-base font-bold text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-sm text-blue-200 truncate font-medium">Paciente</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="ml-auto hidden lg:block">
                    @csrf
                    <button type="submit" class="text-white/70 hover:text-white">
                        <span class="material-icons-outlined">logout</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-20 lg:ml-72 p-6 lg:p-10 max-w-7xl mx-auto w-full">
        <!-- Header -->
        <header class="flex justify-between items-start mb-10">
            <div>
                <h1 class="text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">@yield('header_title', 'Buenos Días, ' . explode(' ', auth()->user()->name)[0]) 👋</h1>
                <p class="text-slate-600 dark:text-slate-300 mt-2 text-lg font-medium">@yield('header_subtitle', 'Tu resumen de salud para el ' . now()->locale('es')->isoFormat('D [de] MMMM'))</p>
            </div>
            <div class="flex gap-4">
                <button class="w-12 h-12 rounded-2xl bg-white dark:bg-surface-dark border-2 border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-700 dark:text-slate-200 hover:text-med-blue hover:border-med-blue transition-all shadow-md relative">
                    <span class="material-icons-outlined text-2xl">notifications</span>
                    <span class="absolute top-2 right-2 w-3 h-3 bg-red-600 rounded-full border-2 border-white dark:border-surface-dark"></span>
                </button>
                <a href="{{ route('profile.edit') }}" class="w-12 h-12 rounded-2xl bg-white dark:bg-surface-dark border-2 border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-700 dark:text-slate-200 hover:text-med-blue hover:border-med-blue transition-all shadow-md">
                    <span class="material-icons-outlined text-2xl">settings</span>
                </a>
            </div>
        </header>

        @if(session('success') || session('status'))
            <div class="mb-8 p-4 bg-green-50 text-green-700 rounded-xl border border-green-200 flex items-center">
                <span class="material-icons-outlined mr-2">check_circle</span>
                {{ session('success') ?? session('status') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
