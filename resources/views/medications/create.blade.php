@extends('layouts.patient')

@section('title', 'Add Medication')
@section('subtitle', 'Register a new prescription or supplement')

@section('header')
    <a href="{{ route('medications.index') }}" class="text-blue-100 hover:text-white flex items-center transition">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Cancel
    </a>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        <form action="{{ route('medications.store') }}" method="POST" class="glass-card p-8">
            @csrf
            
            <div class="space-y-6">
                <!-- Name -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Medication Name</label>
                    <input type="text" name="name" class="input-field" placeholder="e.g. Amoxicillin" value="{{ old('name') }}" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Dosage -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Dosage</label>
                    <input type="text" name="dosage" class="input-field" placeholder="e.g. 500mg" value="{{ old('dosage') }}" required>
                    @error('dosage') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Instructions -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Instructions</label>
                    <textarea name="instructions" rows="3" class="input-field" placeholder="e.g. Take with food after breakfast">{{ old('instructions') }}</textarea>
                    @error('instructions') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div class="grid grid-cols-2 gap-6">
                    <!-- Total Stock -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Total Pack Size</label>
                        <input type="number" name="total_stock" class="input-field" placeholder="e.g. 30" min="1" value="{{ old('total_stock') }}" required>
                        <p class="text-xs text-slate-400 mt-1">Total pills/doses in the box</p>
                        @error('total_stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Current Stock -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Current Combined Stock</label>
                        <input type="number" name="current_stock" class="input-field" placeholder="e.g. 28" min="0" value="{{ old('current_stock') }}" required>
                        <p class="text-xs text-slate-400 mt-1">How many you have right now</p>
                        @error('current_stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Hidden Image Path for now until file upload is implemented -->
                <input type="hidden" name="image_path" value="">

                <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-4">
                    <button type="submit" class="btn-primary">
                        Save Medication
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
