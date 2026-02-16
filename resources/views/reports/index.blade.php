@extends('layouts.patient')

@section('title', 'Reports & Analytics')
@section('subtitle', 'Track your health progress and achievements')

@section('header')
    <a href="{{ route('health.pdf.download') }}" class="btn-secondary flex items-center bg-white shadow-sm border border-slate-200 hover:bg-slate-50">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
        </svg>
        Download Summary
    </a>
@endsection

@section('content')
    <!-- Top Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <!-- Weekly Score Card -->
        <div class="glass-card p-8 flex items-center justify-between bg-gradient-to-br from-indigo-500 to-blue-600 text-white shadow-lg shadow-blue-200 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/20 rounded-full blur-2xl"></div>
            <div>
                <p class="text-blue-100 font-bold uppercase tracking-wider text-sm mb-1">Weekly Adherence Score</p>
                <h2 class="text-5xl font-black tracking-tight">{{ $weeklyScore }}%</h2>
                <p class="text-blue-200 mt-2 text-sm font-medium">Based on your intake history</p>
            </div>
            <div class="w-24 h-24 relative">
                <svg class="transform -rotate-90 w-full h-full" viewBox="0 0 120 120">
                    <circle cx="60" cy="60" r="50" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="12" stroke-linecap="round"/>
                    <circle cx="60" cy="60" r="50" fill="none" stroke="white" stroke-width="12" 
                            stroke-dasharray="{{ $weeklyScore * 3.14 }} 314" stroke-linecap="round" class="drop-shadow-lg"/>
                </svg>
                <div class="absolute inset-0 flex items-center justify-center text-2xl font-bold">
                    {{ $weeklyScore }}
                </div>
            </div>
        </div>

        <!-- Streak Card -->
        <div class="glass-card p-8 flex items-center justify-between bg-gradient-to-br from-orange-400 to-rose-500 text-white shadow-lg shadow-orange-200 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/20 rounded-full blur-2xl"></div>
            <div>
                <p class="text-orange-100 font-bold uppercase tracking-wider text-sm mb-1">Current Streak</p>
                <h2 class="text-5xl font-black tracking-tight">{{ $streak }} Days</h2>
                <p class="text-orange-100 mt-2 text-sm font-medium">Keep the momentum going!</p>
            </div>
            <div class="text-6xl filter drop-shadow-md animate-bounce">
                🔥
            </div>
        </div>
    </div>

    <!-- Charts & Achievements Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Chart Section -->
        <div class="lg:col-span-2 glass-card p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Daily Adherence (Last 7 Days)
            </h3>
            
            <div class="h-64 flex items-end justify-between space-x-2 px-4">
                @foreach($dailyAdherence as $day)
                    <div class="flex flex-col items-center flex-1 group">
                        <div class="text-xs font-bold text-slate-400 mb-2 opacity-0 group-hover:opacity-100 transition-opacity">{{ $day['score'] }}%</div>
                        <div class="w-full bg-slate-100 rounded-t-lg relative overflow-hidden transition-all duration-300 hover:bg-blue-50 cursor-pointer h-48">
                            <div class="absolute bottom-0 left-0 w-full transition-all duration-500 ease-out
                                {{ $day['score'] >= 100 ? 'bg-emerald-500' : ($day['score'] >= 50 ? 'bg-blue-500' : 'bg-slate-300') }}"
                                style="height: {{ $day['score'] }}%"></div>
                        </div>
                        <span class="text-xs font-bold text-slate-500 mt-3">{{ $day['day'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Achievements Section -->
        <div class="glass-card p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
                Recent Achievements
            </h3>
            
            @if($achievements->count() > 0)
                <div class="space-y-4">
                    @foreach($achievements as $achievement)
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 flex items-center transition hover:bg-yellow-50 hover:border-yellow-200">
                            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-2xl shadow-sm mr-4">
                                {{ $achievement->badge_icon ?? '🏆' }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm">{{ $achievement->title }}</h4>
                                <p class="text-xs text-slate-500">{{ $achievement->description }}</p>
                                <span class="text-[10px] lowercase text-slate-400 font-medium mt-1 block">
                                    {{ $achievement->earned_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 text-center">
                    <button class="text-sm font-bold text-blue-600 hover:underline">View All Badges</button>
                </div>
            @else
                <div class="text-center py-8">
                    <span class="text-4xl grayscale opacity-50 block mb-2">🏆</span>
                    <p class="text-slate-400 text-sm">Reviewing your progress...</p>
                </div>
            @endif
        </div>
    </div>
@endsection
