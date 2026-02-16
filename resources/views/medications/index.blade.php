@extends('layouts.patient')

@section('title', 'My Medications')
@section('subtitle', 'Manage your prescriptions and inventory')

@section('header')
    <a href="{{ route('medications.create') }}" class="btn-primary flex items-center shadow-blue-500/30">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Add Medication
    </a>
@endsection

@section('content')
    <!-- Inventory Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="glass-card p-6 flex flex-col items-center text-center">
            <span class="text-3xl mb-2">💊</span>
            <span class="text-4xl font-bold text-slate-800">{{ $medications->count() }}</span>
            <span class="text-sm text-slate-500 font-medium uppercase tracking-wider">Active Prescriptions</span>
        </div>
        
        <div class="glass-card p-6 flex flex-col items-center text-center">
            <span class="text-3xl mb-2">⚠️</span>
            <span class="text-4xl font-bold text-rose-600">{{ $lowStockMeds->count() }}</span>
            <span class="text-sm text-slate-500 font-medium uppercase tracking-wider">Low Stock Alerts</span>
        </div>
        
        <div class="glass-card p-6 flex flex-col items-center text-center">
            <span class="text-3xl mb-2">📅</span>
            <span class="text-4xl font-bold text-blue-600">{{ $medications->sum(fn($m) => $m->schedules->where('is_active', true)->count()) }}</span>
            <span class="text-sm text-slate-500 font-medium uppercase tracking-wider">Daily Doses</span>
        </div>
    </div>

    <!-- Medications Grid -->
    @if($medications->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($medications as $medication)
                <div class="glass-card p-0 overflow-hidden group hover:shadow-2xl transition duration-300">
                    <div class="bg-gradient-to-r from-slate-50 to-slate-100 p-6 border-b border-slate-100 relative">
                        <!-- Color Indicator -->
                        <div class="absolute top-0 right-0 w-16 h-16 bg-gradient-to-br from-white/20 to-white/0 transform rotate-45 translate-x-8 -translate-y-8"></div>
                        
                        <div class="flex justify-between items-start mb-4">
                            <div class="bg-white p-3 rounded-xl shadow-sm border border-slate-100">
                                @if($medication->image_path)
                                    <img src="{{ $medication->image_path }}" alt="{{ $medication->name }}" class="w-10 h-10 object-cover rounded-lg">
                                @else
                                    <span class="text-2xl">💊</span>
                                @endif
                            </div>
                            <div class="dropdown relative" x-data="{ open: false }">
                                <button @click="open = !open" class="text-slate-400 hover:text-slate-600 p-1">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 z-10 py-1" style="display: none;">
                                    <a href="{{ route('medications.edit', $medication) }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Edit Details</a>
                                    <form action="{{ route('medications.destroy', $medication) }}" method="POST" class="block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-rose-600 hover:bg-rose-50" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <h3 class="text-xl font-bold text-slate-800 tracking-tight">{{ $medication->name }}</h3>
                        <p class="text-sm text-slate-500 font-medium">{{ $medication->dosage }}</p>
                    </div>
                    
                    <div class="p-6">
                        <!-- Stock Level -->
                        <div class="mb-6">
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Inventory</span>
                                <span class="text-sm font-bold {{ $medication->isLowStock() ? 'text-rose-600' : 'text-emerald-600' }}">
                                    {{ $medication->current_stock }} / {{ $medication->total_stock }}
                                </span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                <div class="h-2 rounded-full transition-all duration-500 {{ $medication->isLowStock() ? 'bg-rose-500' : 'bg-blue-500' }}" 
                                     style="width: {{ $medication->stock_percentage }}%"></div>
                            </div>
                            @if($medication->isLowStock())
                                <form action="{{ route('medications.refill', $medication) }}" method="POST" class="mt-3">
                                    @csrf
                                    <button type="submit" class="w-full py-2 bg-rose-50 text-rose-700 text-xs font-bold uppercase tracking-wider rounded-lg hover:bg-rose-100 transition border border-rose-200">
                                        Request Refill
                                    </button>
                                </form>
                            @endif
                        </div>
                        
                        <!-- Instructions -->
                        @if($medication->instructions)
                            <div class="bg-slate-50 p-3 rounded-lg border border-slate-100 mb-4">
                                <p class="text-xs text-slate-500 italic">"{{ Str::limit($medication->instructions, 60) }}"</p>
                            </div>
                        @else
                            <div class="h-12"></div> <!-- Spacer for alignment -->
                        @endif
                        
                        <!-- Schedule Info -->
                        <div class="flex items-center space-x-2">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Schedule:</span>
                            <div class="flex space-x-1">
                                @forelse($medication->schedules->where('is_active', true) as $schedule)
                                    <span class="px-2 py-1 bg-blue-50 text-blue-600 text-xs font-bold rounded-md border border-blue-100" title="{{ ucfirst($schedule->time_period) }}">
                                        {{ Carbon\Carbon::parse($schedule->scheduled_time)->format('H:i') }}
                                    </span>
                                @empty
                                    <span class="text-xs text-slate-400">No active schedule</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-20 bg-white/50 rounded-2xl border-2 border-dashed border-slate-300">
            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl text-slate-400">
                💊
            </div>
            <h3 class="text-xl font-bold text-slate-800">No Medications Yet</h3>
            <p class="text-slate-500 max-w-sm mx-auto mt-2 mb-8">Add your prescribed medications to start tracking your inventory and adherence.</p>
            <a href="{{ route('medications.create') }}" class="btn-primary inline-flex items-center">
                Add Medication
            </a>
        </div>
    @endif
@endsection
