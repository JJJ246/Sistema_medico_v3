@extends('layouts.doctor')

@section('title', 'Panel Principal')

@section('breadcrumbs')
    <a href="#" class="hover:text-primary transition-colors">Clínica</a>
    <span class="mx-2 text-slate-300">/</span>
    <span class="text-slate-800 dark:text-white font-medium">Panel Principal</span>
@endsection

@section('content')
    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Patients -->
        <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-2xl shadow-sm border border-border-light dark:border-border-dark flex items-center justify-between group hover:border-primary/50 transition-colors">
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Total Pacientes</p>
                <h3 class="text-3xl font-bold text-slate-800 dark:text-white">{{ $totalPatients }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="material-symbols-rounded">groups</span>
            </div>
        </div>

        <!-- Prescriptions -->
        <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-2xl shadow-sm border border-border-light dark:border-border-dark flex items-center justify-between group hover:border-primary/50 transition-colors">
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Recetas Emitidas</p>
                <h3 class="text-3xl font-bold text-slate-800 dark:text-white">{{ $prescriptionsCount }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="material-symbols-rounded">prescriptions</span>
            </div>
        </div>

        <!-- Adherence Rate -->
        <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-2xl shadow-sm border border-border-light dark:border-border-dark flex items-center justify-between group hover:border-primary/50 transition-colors">
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Adherencia Prom.</p>
                <h3 class="text-3xl font-bold text-slate-800 dark:text-white">{{ $adherenceRate }}%</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="material-symbols-rounded">vital_signs</span>
            </div>
        </div>

        <!-- Inventory Alerts -->
        <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-2xl shadow-sm border border-border-light dark:border-border-dark flex items-center justify-between group hover:border-red-500/50 transition-colors">
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Stock Crítico</p>
                <h3 class="text-3xl font-bold text-slate-800 dark:text-white">{{ $criticalStock }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 flex items-center justify-center group-hover:animate-pulse">
                <span class="material-symbols-rounded">inventory_2</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Chart Section -->
        <div class="lg:col-span-2 space-y-8">
             <!-- Adherence Chart Card -->
            <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-2xl shadow-sm border border-border-light dark:border-border-dark">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-slate-800 dark:text-white text-lg">Análisis de Salud de la Población</h3>
                    <select class="text-sm border-none bg-slate-50 dark:bg-slate-800/50 rounded-lg px-3 py-1 text-slate-600 focus:ring-0 cursor-pointer hover:bg-slate-100">
                        <option>Últimos 30 Días</option>
                        <option>Último Trimestre</option>
                        <option>Año a la Fecha</option>
                    </select>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <!-- Gauge Chart (CSS/SVG) -->
                    <div class="flex flex-col items-center justify-center relative">
                         <div class="relative w-48 h-24 overflow-hidden mb-4">
                            <div class="absolute top-0 left-0 w-48 h-48 rounded-full border-[20px] border-slate-100 dark:border-slate-800"></div>
                            <div class="absolute top-0 left-0 w-48 h-48 rounded-full border-[20px] border-primary border-b-transparent border-l-transparent transform -rotate-45 origin-center" style="transform: rotate(45deg);"></div>
                         </div>
                         <div class="absolute top-16 text-center">
                             <span class="text-4xl font-extrabold text-slate-800 dark:text-white">85%</span>
                             <p class="text-xs text-slate-500 uppercase tracking-wide mt-1">Tasa Adherencia</p>
                         </div>
                    </div>

                    <!-- Bar Chart (CSS) -->
                    <div>
                        <h4 class="text-sm font-bold text-slate-700 dark:text-slate-300 mb-4">Dosis Exitosas vs. Perdidas</h4>
                        <div class="flex items-end space-x-3 h-40">
                             <!-- Mon -->
                             <div class="flex-1 flex flex-col justify-end gap-1 group">
                                 <div class="w-full bg-primary h-[80%] rounded-t-sm opacity-80 group-hover:opacity-100 transition-opacity relative">
                                    <span class="opacity-0 group-hover:opacity-100 absolute -top-6 left-1/2 -translate-x-1/2 text-xs font-bold bg-slate-800 text-white px-2 py-0.5 rounded">140</span>
                                 </div>
                                 <div class="w-full bg-blue-500 h-[20%] rounded-t-sm opacity-80 group-hover:opacity-100 transition-opacity"></div>
                                 <span class="text-[10px] text-center text-slate-400">Lun</span>
                             </div>
                             <!-- Tue -->
                             <div class="flex-1 flex flex-col justify-end gap-1 group">
                                 <div class="w-full bg-primary h-[90%] rounded-t-sm opacity-80 group-hover:opacity-100 transition-opacity"></div>
                                 <div class="w-full bg-blue-500 h-[10%] rounded-t-sm opacity-80 group-hover:opacity-100 transition-opacity"></div>
                                 <span class="text-[10px] text-center text-slate-400">Mar</span>
                             </div>
                             <!-- Wed -->
                             <div class="flex-1 flex flex-col justify-end gap-1 group">
                                 <div class="w-full bg-primary h-[75%] rounded-t-sm opacity-80 group-hover:opacity-100 transition-opacity"></div>
                                 <div class="w-full bg-blue-500 h-[15%] rounded-t-sm opacity-80 group-hover:opacity-100 transition-opacity"></div>
                                 <span class="text-[10px] text-center text-slate-400">Mié</span>
                             </div>
                             <!-- Thu -->
                             <div class="flex-1 flex flex-col justify-end gap-1 group">
                                 <div class="w-full bg-primary h-[85%] rounded-t-sm opacity-80 group-hover:opacity-100 transition-opacity"></div>
                                 <div class="w-full bg-blue-500 h-[25%] rounded-t-sm opacity-80 group-hover:opacity-100 transition-opacity"></div>
                                 <span class="text-[10px] text-center text-slate-400">Jue</span>
                             </div>
                             <!-- Fri -->
                             <div class="flex-1 flex flex-col justify-end gap-1 group">
                                 <div class="w-full bg-primary h-[95%] rounded-t-sm opacity-80 group-hover:opacity-100 transition-opacity"></div>
                                 <div class="w-full bg-blue-500 h-[30%] rounded-t-sm opacity-80 group-hover:opacity-100 transition-opacity"></div>
                                 <span class="text-[10px] text-center text-slate-400">Vie</span>
                             </div>
                             <!-- Sat -->
                             <div class="flex-1 flex flex-col justify-end gap-1 group">
                                 <div class="w-full bg-primary h-[88%] rounded-t-sm opacity-80 group-hover:opacity-100 transition-opacity"></div>
                                 <div class="w-full bg-blue-500 h-[12%] rounded-t-sm opacity-80 group-hover:opacity-100 transition-opacity"></div>
                                 <span class="text-[10px] text-center text-slate-400">Sáb</span>
                             </div>
                             <!-- Sun -->
                             <div class="flex-1 flex flex-col justify-end gap-1 group">
                                 <div class="w-full bg-primary h-[82%] rounded-t-sm opacity-80 group-hover:opacity-100 transition-opacity"></div>
                                 <div class="w-full bg-blue-500 h-[18%] rounded-t-sm opacity-80 group-hover:opacity-100 transition-opacity"></div>
                                 <span class="text-[10px] text-center text-slate-400">Dom</span>
                             </div>
                        </div>
                         <div class="flex items-center justify-center gap-4 mt-4">
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <span class="w-2 h-2 bg-primary rounded-full"></span> Exitoso
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <span class="w-2 h-2 bg-blue-500 rounded-full"></span> Perdido
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activity Table -->
            <div class="bg-surface-light dark:bg-surface-dark rounded-2xl shadow-sm border border-border-light dark:border-border-dark overflow-hidden">
                <div class="p-6 border-b border-border-light dark:border-border-dark">
                    <h3 class="font-bold text-slate-800 dark:text-white">Recetas Recientes</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-slate-500 uppercase bg-slate-50 dark:bg-slate-800/50">
                            <tr>
                                <th class="px-6 py-3">Paciente</th>
                                <th class="px-6 py-3">Medicamento</th>
                                <th class="px-6 py-3">Estado</th>
                                <th class="px-6 py-3">Fecha</th>
                                <th class="px-6 py-3 text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-light dark:divide-border-dark">
                            @foreach($recentPrescriptions as $prescription)
                            <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-slate-900 dark:text-white flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-xs font-bold text-slate-500">
                                        {{ substr($prescription->patient->name, 0, 2) }}
                                    </div>
                                    {{ $prescription->patient->full_name ?? $prescription->patient->name }}
                                </td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                                    {{ $prescription->medication->name }}
                                    <span class="text-xs text-slate-400 block">{{ $prescription->medication->dosage }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        Activo
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-500">
                                    {{ $prescription->created_at->format('d M, Y') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-slate-400 hover:text-primary transition-colors">
                                        <span class="material-symbols-rounded text-[20px]">visibility</span>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar Widgets -->
        <div class="space-y-8">
            <!-- Top Prescribed Drugs -->
            <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-2xl shadow-sm border border-border-light dark:border-border-dark">
                <h3 class="font-bold text-slate-800 dark:text-white mb-4">Medicamentos Más Recetados</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="text-slate-400 font-mono text-sm">01</span>
                            <span class="font-medium text-slate-700 dark:text-slate-200">Amoxicilina</span>
                        </div>
                        <span class="text-xs font-bold bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded">450</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="text-slate-400 font-mono text-sm">02</span>
                            <span class="font-medium text-slate-700 dark:text-slate-200">Metformina</span>
                        </div>
                        <span class="text-xs font-bold bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded">320</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="text-slate-400 font-mono text-sm">03</span>
                            <span class="font-medium text-slate-700 dark:text-slate-200">Lisinopril</span>
                        </div>
                        <span class="text-xs font-bold bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded">210</span>
                    </div>
                </div>
                <button class="w-full mt-6 py-2 text-sm font-medium text-primary hover:text-primary-focus transition-colors">
                    Ver Reporte Completo
                </button>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-primary to-emerald-600 p-6 rounded-2xl shadow-lg shadow-primary/30 text-white">
                <h3 class="font-bold text-lg mb-2">Acciones Rápidas</h3>
                <p class="text-blue-50 text-sm mb-6 opacity-90">Administre su clínica eficientemente.</p>
                
                <div class="space-y-3">
                    <a href="{{ route('prescriptions.create') }}" class="flex items-center gap-3 bg-white/20 hover:bg-white/30 p-3 rounded-lg backdrop-blur-sm transition-colors cursor-pointer">
                        <span class="material-symbols-rounded">add_circle</span>
                        <span class="font-medium text-sm">Nueva Receta</span>
                    </a>
                    <a href="{{ route('doctor.patients') }}" class="flex items-center gap-3 bg-white/20 hover:bg-white/30 p-3 rounded-lg backdrop-blur-sm transition-colors cursor-pointer">
                        <span class="material-symbols-rounded">person_add</span>
                        <span class="font-medium text-sm">Agregar Paciente</span>
                    </a>
                    <a href="{{ route('doctor.inventory') }}" class="flex items-center gap-3 bg-white/20 hover:bg-white/30 p-3 rounded-lg backdrop-blur-sm transition-colors cursor-pointer">
                        <span class="material-symbols-rounded">inventory</span>
                        <span class="font-medium text-sm">Actualizar Stock</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
