@extends('layouts.patient')

@section('title', 'My Doctors')
@section('subtitle', 'Your healthcare team directory')

@section('content')
    @if($doctors->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($doctors as $doctor)
                <div class="glass-card overflow-hidden group hover:-translate-y-1 hover:shadow-2xl transition duration-300">
                    <!-- Header / Cover -->
                    <div class="h-24 bg-gradient-to-r from-blue-500 to-indigo-600 relative">
                        <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition duration-300"></div>
                    </div>
                    
                    <div class="px-6 pb-6 relative">
                        <!-- Avatar -->
                        <div class="absolute -top-12 left-6 p-1 bg-white rounded-2xl shadow-md">
                        <div class="absolute -top-12 left-6 p-1 bg-white rounded-2xl shadow-md">
                            <img src="{{ $doctor->profile_photo_url }}" alt="{{ $doctor->name }}" class="w-20 h-20 object-cover rounded-xl">
                        </div>
                        </div>
                        
                        <div class="mt-12">
                            <h3 class="text-xl font-bold text-slate-800">{{ $doctor->full_name ?? $doctor->name }}</h3>
                            <p class="text-blue-600 text-sm font-medium uppercase tracking-wide mb-4">General Practitioner</p>
                            
                            <div class="space-y-3 mb-6">
                                <div class="flex items-center text-sm text-slate-600">
                                    <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $doctor->email }}
                                </div>
                                <div class="flex items-center text-sm text-slate-600">
                                    <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    {{ $doctor->medications->count() }} Prescriptions
                                </div>
                            </div>
                            
                            <a href="{{ route('doctors.show', $doctor) }}" class="block w-full text-center py-2 bg-slate-50 hover:bg-blue-50 text-slate-700 hover:text-blue-700 font-bold rounded-lg border border-slate-200 hover:border-blue-200 transition">
                                View Profile
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-20 bg-white/50 rounded-2xl border-2 border-dashed border-slate-300">
            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl text-slate-400">
                👨‍⚕️
            </div>
            <h3 class="text-xl font-bold text-slate-800">No Doctors Linked</h3>
            <p class="text-slate-500 max-w-sm mx-auto mt-2">You haven't been assigned to any doctors yet.</p>
        </div>
    @endif
@endsection
