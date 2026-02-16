@extends('layouts.patient')

@section('title', 'Horario')
@section('subtitle', 'Tu cronograma diario de medicamentos')

@section('header')
    <div class="flex items-center space-x-2 text-sm text-slate-500 bg-white/50 px-3 py-1 rounded-lg border border-slate-200">
        <span>Hoy:</span>
        <span class="font-bold text-slate-700">{{ now()->locale('es')->isoFormat('dddd, D [de] MMM') }}</span>
    </div>
@endsection

@section('content')
    <!-- Date Navigation -->
    <div class="glass-panel p-4 mb-8 flex justify-between items-center overflow-x-auto">
        @foreach($weekDates as $d)
            <a href="{{ route('schedule.index', ['date' => $d->format('Y-m-d')]) }}" 
               class="flex flex-col items-center min-w-[4rem] p-3 rounded-xl transition-all duration-200 
               {{ $d->isSameDay($date) ? 'bg-blue-600 text-white shadow-lg shadow-blue-200 transform scale-105' : 'hover:bg-white text-slate-500 hover:text-slate-800' }}">
                <span class="text-xs font-semibold uppercase tracking-wider mb-1 opacity-80">{{ $d->locale('es')->isoFormat('ddd') }}</span>
                <span class="text-xl font-bold">{{ $d->format('d') }}</span>
                @if($d->isToday())
                    <span class="mt-1 w-1.5 h-1.5 rounded-full {{ $d->isSameDay($date) ? 'bg-white' : 'bg-blue-500' }}"></span>
                @endif
            </a>
        @endforeach
    </div>

    <!-- Timeline -->
    <div class="space-y-8 relative">
        <!-- Vertical Line -->
        <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-slate-200 hidden md:block"></div>

        @foreach(['morning' => 'Mañana', 'afternoon' => 'Tarde', 'evening' => 'Noche', 'night' => 'Madrugada'] as $periodKey => $periodLabel)
            @php $periodSchedules = $schedulesByPeriod[$periodKey]; @endphp
            
            <div class="relative pl-0 md:pl-20">
                <!-- Time Period Marker (Left) -->
                <div class="hidden md:flex absolute left-0 top-0 w-16 h-16 bg-white rounded-2xl border-2 border-slate-100 items-center justify-center shadow-sm z-10
                    {{ $periodSchedules->count() > 0 ? 'text-blue-600 border-blue-100' : 'text-slate-300' }}">
                    @if($periodKey == 'morning') <span class="text-2xl">🌅</span>
                    @elseif($periodKey == 'afternoon') <span class="text-2xl">☀️</span>
                    @elseif($periodKey == 'evening') <span class="text-2xl">🌇</span>
                    @else <span class="text-2xl">🌙</span>
                    @endif
                </div>

                <!-- Section Header -->
                <h3 class="text-lg font-bold text-slate-800 capitalize mb-4 flex items-center md:hidden">
                    <span class="mr-2 text-xl">
                        @if($periodKey == 'morning') 🌅
                        @elseif($periodKey == 'afternoon') ☀️
                        @elseif($periodKey == 'evening') 🌇
                        @else 🌙
                        @endif
                    </span>
                    {{ $periodLabel }}
                </h3>

                <!-- Medication Cards -->
                @if($periodSchedules->count() > 0)
                    <div class="space-y-4">
                        @foreach($periodSchedules as $schedule)
                            @php
                                $log = $schedule->adherenceLogs->first();
                                $status = $log ? $log->status : 'pending';
                                $isFuture = $date->isFuture() || ($date->isToday() && now()->format('H:i:s') < $schedule->scheduled_time);
                            @endphp
                            
                            <div class="glass-card p-5 border-l-4 transition-all duration-300 hover:shadow-lg
                                {{ $status == 'taken' ? 'border-l-emerald-500 bg-emerald-50/30' : 
                                   ($status == 'missed' ? 'border-l-rose-500 bg-rose-50/30' : 'border-l-blue-500') }}">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                                    <div class="flex items-center mb-4 sm:mb-0">
                                        <div class="mr-4 text-center">
                                            <span class="block text-lg font-bold text-slate-700">{{ Carbon\Carbon::parse($schedule->scheduled_time)->format('H:i') }}</span>
                                            <span class="text-xs text-slate-400 uppercase tracking-wide">Hora</span>
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-bold text-slate-800">{{ $schedule->medication->name }}</h4>
                                            <div class="flex items-center text-sm text-slate-500">
                                                <span class="font-medium bg-slate-100 px-2 py-0.5 rounded text-slate-600 border border-slate-200 mr-2">
                                                    {{ $schedule->medication->dosage }}
                                                </span>
                                                @if($schedule->medication->instructions)
                                                    <span class="italic text-xs truncate max-w-[150px] sm:max-w-xs">
                                                        {{ $schedule->medication->instructions }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex space-x-3 w-full sm:w-auto">
                                        @if($status == 'taken')
                                            <span class="flex items-center px-4 py-2 bg-emerald-100 text-emerald-700 rounded-lg text-sm font-bold shadow-sm">
                                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                Tomado
                                            </span>
                                        @elseif($status == 'skipped')
                                            <span class="flex items-center px-4 py-2 bg-slate-100 text-slate-500 rounded-lg text-sm font-bold">
                                                Saltado
                                            </span>
                                        @else
                                            @if($date->isToday())
                                                <form action="{{ route('adherence.taken', $schedule) }}" method="POST" class="flex-1 sm:flex-none">
                                                    @csrf
                                                    <button type="submit" class="w-full sm:w-auto px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-bold shadow-md hover:bg-blue-700 transition active:scale-95">
                                                        Tomar
                                                    </button>
                                                </form>
                                                <form action="{{ route('adherence.snooze', $schedule) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="minutes" value="15">
                                                    <button type="submit" class="px-5 py-2 bg-white border border-slate-200 text-slate-600 rounded-lg text-sm font-bold hover:bg-slate-50 transition active:scale-95" title="Posponer 15m">
                                                        💤
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-sm text-slate-400 italic">Programado</span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="h-24 border-2 border-dashed border-slate-200 rounded-xl flex items-center justify-center text-slate-400 text-sm">
                        No hay medicamentos para la {{ strtolower($periodLabel) }}
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endsection
