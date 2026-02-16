<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MediCore') }} - @yield('title', 'Doctor Portal')</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#10b77f",
                        "primary-focus": "#0e9f6e",
                        "background-light": "#f6f8f7",
                        "background-dark": "#10221c",
                        "surface-light": "#ffffff",
                        "surface-dark": "#162e25",
                        "border-light": "#e5e7eb",
                        "border-dark": "#1f3a31",
                    },
                    fontFamily: {
                        "display": ["Manrope", "sans-serif"]
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-rounded { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .material-symbols-filled { font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .filament-input:focus { outline: none; border-color: #10b77f; box-shadow: 0 0 0 2px rgba(16, 183, 127, 0.2); }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-800 dark:text-slate-100 font-display antialiased h-screen flex overflow-hidden">
    <!-- Sidebar Navigation -->
    <aside class="w-64 flex-shrink-0 bg-surface-light dark:bg-surface-dark border-r border-border-light dark:border-border-dark flex flex-col transition-all duration-300 z-20">
        <!-- Logo Area -->
        <div class="h-16 flex items-center px-6 border-b border-border-light dark:border-border-dark">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white">
                    <span class="material-symbols-rounded">medical_services</span>
                </div>
                <span class="font-bold text-lg tracking-tight text-slate-900 dark:text-white">MediCore</span>
            </div>
        </div>
        
        <!-- Navigation Links -->
        <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-1">
            <a href="{{ route('doctor.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors group {{ request()->routeIs('doctor.dashboard') ? 'bg-primary/10 text-primary' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-primary/10 hover:text-primary' }}">
                <span class="material-symbols-rounded {{ request()->routeIs('doctor.dashboard') ? 'text-primary' : 'text-slate-400 group-hover:text-primary transition-colors' }}">dashboard</span>
                <span class="font-medium text-sm">Panel Principal</span>
            </a>
            
            <div class="pt-4 pb-2 px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Clínica</div>
            
            <a href="{{ route('doctor.patients') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors group {{ request()->routeIs('doctor.patients') ? 'bg-primary/10 text-primary' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-primary/10 hover:text-primary' }}">
                <span class="material-symbols-rounded {{ request()->routeIs('doctor.patients') ? 'text-primary' : 'text-slate-400 group-hover:text-primary transition-colors' }}">groups</span>
                <span class="font-medium text-sm">Pacientes</span>
            </a>
            
            <a href="{{ route('prescriptions.create') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors group {{ request()->routeIs('prescriptions.*') ? 'bg-primary/10 text-primary' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-primary/10 hover:text-primary' }}">
                <span class="material-symbols-filled {{ request()->routeIs('prescriptions.*') ? 'text-primary' : 'text-slate-400 group-hover:text-primary transition-colors' }}">prescriptions</span>
                <span class="font-medium text-sm">Recetas</span>
            </a>
            
            <div class="pt-4 pb-2 px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Gestión</div>
            
            <a href="{{ route('doctor.inventory') ?? '#' }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors group {{ request()->routeIs('doctor.inventory') ? 'bg-primary/10 text-primary' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-primary/10 hover:text-primary' }}">
                <span class="material-symbols-rounded {{ request()->routeIs('doctor.inventory') ? 'text-primary' : 'text-slate-400 group-hover:text-primary transition-colors' }}">inventory_2</span>
                <span class="font-medium text-sm">Inventario</span>
            </a>
            
            <div class="pt-4 pb-2 px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Reportes</div>

            <a href="{{ route('prescriptions.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors group {{ request()->routeIs('prescriptions.index') ? 'bg-primary/10 text-primary' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-primary/10 hover:text-primary' }}">
                <span class="material-symbols-rounded {{ request()->routeIs('prescriptions.index') ? 'text-primary' : 'text-slate-400 group-hover:text-primary transition-colors' }}">history_edu</span>
                <span class="font-medium text-sm">Historial de Recetas</span>
            </a>
        </nav>
        
        <!-- User Profile -->
        <div class="p-4 border-t border-border-light dark:border-border-dark">
            <div class="flex items-center gap-3 cursor-pointer hover:bg-slate-50 dark:hover:bg-primary/10 p-2 rounded-lg transition-colors">
                <img class="w-9 h-9 rounded-full object-cover border border-slate-200 dark:border-slate-600" src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}">
                <div class="flex flex-col overflow-hidden">
                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-200 truncate">{{ auth()->user()->name }}</span>
                    <span class="text-xs text-slate-500 truncate">{{ auth()->user()->role === 'admin' ? 'Administrador' : 'Doctor' }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="ml-auto">
                    @csrf
                    <button type="submit" class="text-slate-400 hover:text-primary transition-colors" title="Cerrar Sesión">
                        <span class="material-symbols-rounded text-xl">logout</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <main class="flex-1 flex flex-col h-full overflow-hidden relative">
        <!-- Top Header -->
        <header class="h-16 bg-surface-light/80 dark:bg-surface-dark/80 backdrop-blur-md border-b border-border-light dark:border-border-dark flex items-center justify-between px-6 z-10">
            <!-- Breadcrumbs -->
            <nav class="flex items-center text-sm text-slate-500">
                @yield('breadcrumbs')
            </nav>
            
            <!-- Actions -->
            <div class="flex items-center gap-4">
                <button class="w-8 h-8 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 flex items-center justify-center text-slate-500 transition-colors">
                    <span class="material-symbols-rounded text-[20px]">search</span>
                </button>
                <div class="relative">
                    <button class="w-8 h-8 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 flex items-center justify-center text-slate-500 transition-colors">
                        <span class="material-symbols-rounded text-[20px]">notifications</span>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border border-white dark:border-surface-dark"></span>
                    </button>
                </div>
            </div>
        </header>
        
        <!-- Scrollable Content Area -->
        <div class="flex-1 overflow-y-auto p-6 lg:p-8">
             @if(session('success'))
                <div class="mb-6 p-4 bg-primary/10 text-primary-focus rounded-lg border border-primary/20 flex items-center gap-2">
                    <span class="material-symbols-rounded">check_circle</span>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif
            
            @yield('content')
        </div>
    </main>
</body>
</html>
