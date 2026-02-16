@extends('layouts.patient')

@section('title', 'Dashboard')

@section('content')
    <style>
        .progress-circle {
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }
    </style>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <!-- Action Required Card -->
        <div class="lg:col-span-2 bg-white dark:bg-surface-dark rounded-3xl p-8 shadow-xl relative overflow-hidden border-l-8 border-med-blue">
            @if($nextMedication)
                <div class="flex flex-col md:flex-row items-center gap-8 relative z-10">
                    <div class="flex-1 space-y-8">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-sm font-bold uppercase tracking-wider shadow-sm">
                            <span class="w-3 h-3 rounded-full bg-red-600 animate-ping"></span>
                            <span class="w-3 h-3 rounded-full bg-red-600 absolute ml-0"></span>
                            Acción Requerida
                        </div>
                        <div>
                            <h2 class="text-5xl font-extrabold text-slate-900 dark:text-white mb-3">
                                {{ $nextMedication->medication->name }} 
                                <span class="text-3xl text-slate-500 font-bold block sm:inline mt-1 sm:mt-0">{{ $nextMedication->medication->dosage }}</span>
                            </h2>
                            <div class="flex items-center gap-6 text-slate-700 dark:text-slate-300 text-lg font-medium">
                                <span class="flex items-center gap-2 bg-slate-100 dark:bg-slate-800 px-3 py-1 rounded-lg">
                                    <span class="material-icons-outlined text-med-blue">schedule</span>
                                    {{ \Carbon\Carbon::parse($nextMedication->scheduled_time)->format('h:i A') }}
                                </span>
                                @if($nextMedication->medication->instructions)
                                    <span class="flex items-center gap-2 bg-slate-100 dark:bg-slate-800 px-3 py-1 rounded-lg">
                                        <span class="material-icons-outlined text-primary">info</span>
                                        {{ Str::limit($nextMedication->medication->instructions, 20) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-4">
                            <form action="{{ route('adherence.taken', $nextMedication) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full bg-med-blue hover:bg-med-blue-dark text-white px-8 py-5 rounded-2xl font-bold text-lg shadow-lg shadow-blue-500/30 hover:shadow-blue-600/50 transition-all flex items-center justify-center gap-3 transform active:scale-95 ring-4 ring-blue-100 dark:ring-blue-900/30">
                                    <span class="material-icons-outlined text-2xl">check_circle</span>
                                    Marcar como Tomado
                                </button>
                            </form>
                            <form action="{{ route('adherence.snooze', $nextMedication) }}" method="POST">
                                @csrf
                                <input type="hidden" name="minutes" value="10">
                                <button type="submit" class="bg-slate-100 dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 hover:border-med-blue text-slate-900 dark:text-white px-6 py-5 rounded-2xl font-bold text-lg transition-all flex items-center gap-2 shadow-sm hover:shadow-md">
                                    <span class="material-icons-outlined">snooze</span>
                                    10m
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="relative w-48 h-48 md:w-60 md:h-60 shrink-0 hidden md:block">
                        <!-- Placeholder Doctor Image -->
                        <img alt="Friendly doctor" class="w-full h-full object-cover rounded-3xl shadow-xl border-4 border-slate-100 dark:border-slate-700" src="https://ui-avatars.com/api/?name=Doctor&background=0D8ABC&color=fff&size=200">
                        <div class="absolute -bottom-4 -right-4 bg-primary text-white p-4 rounded-2xl shadow-lg flex items-center gap-2 transform rotate-2">
                            <span class="material-icons-outlined text-2xl">thumb_up</span>
                            <span class="text-sm font-bold whitespace-nowrap">¡Aprobado!</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="flex flex-col items-center justify-center h-full min-h-[300px] text-center">
                    <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mb-6">
                        <span class="material-icons-outlined text-green-600 text-5xl">verified</span>
                    </div>
                    <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white mb-2">¡Todo al día!</h2>
                    <p class="text-slate-500 text-lg max-w-md">Has tomado todos tus medicamentos programados por ahora. ¡Gran trabajo!</p>
                </div>
            @endif
        </div>

        <!-- Adherence Score Card -->
        <div class="bg-white dark:bg-surface-dark rounded-3xl p-8 shadow-xl flex flex-col items-center justify-center text-center relative border border-slate-100 dark:border-slate-800">
            <div class="absolute top-0 inset-x-0 h-2 bg-gradient-to-r from-primary to-med-blue"></div>
            <h3 class="text-xl font-extrabold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                <span class="material-icons-outlined text-med-blue text-2xl">insights</span> Puntaje Adherencia
            </h3>
            <div class="relative w-48 h-48 mb-8">
                <svg class="w-full h-full progress-circle" viewBox="0 0 100 100">
                    <circle class="dark:stroke-slate-800" cx="50" cy="50" fill="none" r="42" stroke="#f1f5f9" stroke-width="10"></circle>
                    <circle cx="50" cy="50" fill="none" r="42" stroke="#10b77f" stroke-dasharray="264" stroke-dashoffset="{{ 264 - (264 * $weeklyScore / 100) }}" stroke-linecap="round" stroke-width="10"></circle>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-5xl font-black text-slate-900 dark:text-white tracking-tight">{{ $weeklyScore }}%</span>
                    <span class="text-sm font-bold text-slate-500 uppercase tracking-widest mt-1">Semanal</span>
                </div>
            </div>
            <div class="bg-gradient-to-r from-orange-50 to-amber-50 dark:from-orange-900/20 dark:to-amber-900/20 rounded-2xl p-4 w-full border border-orange-100 dark:border-orange-800/30 shadow-inner">
                <div class="flex items-center justify-center gap-2 mb-1">
                    <span class="material-icons-outlined text-orange-500 text-2xl animate-pulse">local_fire_department</span>
                    <span class="font-black text-orange-600 dark:text-orange-400 text-lg">¡Racha de {{ $streak }} Días!</span>
                </div>
                <p class="text-sm font-medium text-slate-700 dark:text-slate-300 leading-tight">Sigue así para ganar la insignia 'Semana Perfecta'.</p>
            </div>
        </div>
    </div>

    <!-- Upcoming Medications -->
    <section>
        <div class="flex justify-between items-end mb-8">
            <div>
                <h3 class="text-2xl font-black text-slate-900 dark:text-white">Próximos Medicamentos</h3>
                <p class="text-base font-medium text-slate-500 dark:text-slate-400 mt-1">Programados para hoy</p>
            </div>
            <a href="{{ route('schedule.index') }}" class="bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white hover:bg-med-blue hover:text-white px-5 py-2.5 rounded-xl font-bold text-sm flex items-center gap-2 transition-all shadow-sm">
                Ver Horario Completo
                <span class="material-icons-outlined text-base">arrow_forward</span>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($upcomingMedications as $schedule)
                @php
                    $isLowStock = $schedule->medication->isLowStock();
                    $statusColor = $isLowStock ? 'red' : ($loop->first ? 'orange' : 'blue');
                    $statusText = $isLowStock ? 'Stock Bajo' : ($loop->first ? 'Pendiente' : 'Próximo');
                @endphp
                
                <div class="bg-white dark:bg-surface-dark rounded-3xl p-5 shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 group border-t-4 border-{{ $statusColor }}-400">
                    <div class="flex flex-col h-full">
                        <div class="flex items-center justify-between mb-4">
                            <span class="bg-{{ $statusColor }}-100 dark:bg-{{ $statusColor }}-900/40 text-{{ $statusColor }}-700 dark:text-{{ $statusColor }}-300 px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-{{ $statusColor }}-500"></span>
                                {{ $statusText }}
                            </span>
                            <span class="text-slate-400 dark:text-slate-500 font-mono text-sm">#RX0{{ $schedule->medication->id }}</span>
                        </div>
                        <div class="flex gap-4 items-center mb-4">
                            <div class="w-20 h-20 rounded-2xl overflow-hidden shrink-0 shadow-md flex items-center justify-center bg-slate-100 text-2xl">
                                @if($schedule->medication->image_path)
                                    <img src="{{ $schedule->medication->image_path }}" class="w-full h-full object-cover">
                                @else
                                    💊
                                @endif
                            </div>
                            <div class="flex flex-col">
                                <h4 class="text-xl font-extrabold text-slate-900 dark:text-white leading-tight">{{ $schedule->medication->name }}</h4>
                                <span class="text-base font-bold text-med-blue dark:text-blue-400 mt-0.5">{{ $schedule->medication->dosage }}</span>
                            </div>
                        </div>
                        <div class="mt-auto pt-4 border-t-2 border-slate-100 dark:border-slate-800">
                            @if($isLowStock)
                                <form action="{{ route('medications.refill', $schedule->medication) }}" method="POST">
                                    @csrf
                                    <button class="w-full bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/40 text-red-600 dark:text-red-300 py-3 rounded-xl font-bold transition-colors shadow-sm border border-red-100 dark:border-red-800">
                                        Solicitar Recarga
                                    </button>
                                </form>
                            @else
                                <div class="flex items-center justify-between">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold text-slate-400 uppercase">Hora</span>
                                        <div class="flex items-center gap-1 text-slate-900 dark:text-white font-bold text-lg">
                                            <span class="material-icons-outlined text-med-blue text-base">schedule</span>
                                            {{ \Carbon\Carbon::parse($schedule->scheduled_time)->format('h:i A') }}
                                        </div>
                                    </div>
                                    <form action="{{ route('adherence.taken', $schedule) }}" method="POST">
                                        @csrf
                                        <button class="bg-slate-100 hover:bg-med-blue hover:text-white text-slate-600 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-med-blue p-3 rounded-xl transition-colors shadow-sm" title="Mark Taken">
                                            <span class="material-icons-outlined text-xl">check</span>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-slate-50 dark:bg-slate-800/50 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-700">
                    <p class="text-slate-500 font-medium">¡No hay más medicamentos programados para hoy!</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection
