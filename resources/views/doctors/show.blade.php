@extends('layouts.patient')

@section('title', 'Doctor Profile')
@section('subtitle', 'View professional details and prescriptions')

@section('header')
    <a href="{{ route('doctors.index') }}" class="flex items-center text-blue-100 hover:text-white transition">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Directory
    </a>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Doctor Info Column -->
        <div class="lg:col-span-1">
            <div class="glass-card p-8 text-center sticky top-8">
                <div class="w-32 h-32 bg-slate-100 rounded-full mx-auto mb-6 flex items-center justify-center text-5xl shadow-md border-4 border-white">
                    <img src="{{ $doctor->profile_photo_url }}" alt="{{ $doctor->name }}" class="w-full h-full object-cover rounded-full">
                </div>
                
                <h2 class="text-2xl font-bold text-slate-800">{{ $doctor->full_name ?? $doctor->name }}</h2>
                <p class="text-blue-600 font-medium uppercase tracking-wide text-sm mb-6">General Practitioner</p>
                
                <div class="space-y-4 text-left">
                    <div class="flex items-center p-3 bg-slate-50 rounded-lg">
                        <div class="bg-white p-2 rounded-md shadow-sm mr-3 text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase font-bold">Email</p>
                            <p class="text-slate-800 font-medium break-all">{{ $doctor->email }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 pt-6 border-t border-slate-100">
                    <button class="w-full btn-primary shadow-lg shadow-blue-200">
                        Send Message
                    </button>
                    <button class="w-full btn-secondary mt-3">
                        Book Appointment
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Prescribed Medications Column -->
        <div class="lg:col-span-2">
            <div class="glass-card p-8">
                <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Prescribed Medications
                </h3>
                
                @if($doctor->medications->count() > 0)
                    <div class="space-y-4">
                        @foreach($doctor->medications as $medication)
                            <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-100 transition hover:bg-white hover:shadow-md">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center text-xl shadow-sm mr-4 border border-slate-100">
                                        💊
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800">{{ $medication->name }}</h4>
                                        <p class="text-sm text-slate-500">{{ $medication->dosage }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-bold uppercase text-slate-400 block mb-1">Status</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $medication->isLowStock() ? 'bg-rose-100 text-rose-800' : 'bg-emerald-100 text-emerald-800' }}">
                                        {{ $medication->isLowStock() ? 'Low Stock' : 'Active' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 border-2 border-dashed border-slate-200 rounded-xl">
                        <p class="text-slate-500">No active prescriptions from this doctor.</p>
                    </div>
                @endif
            </div>
            
            <!-- Recent Activity / Notes Mockup -->
            <div class="glass-card p-8 mt-8 opacity-60">
                <h3 class="text-xl font-bold text-slate-800 mb-4 opacity-50">Recent Notes</h3>
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <p class="text-slate-400 italic text-center">No recent consultation notes available.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
