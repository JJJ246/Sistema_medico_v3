@extends('layouts.patient')

@section('title', 'Edit Medication')
@section('subtitle', 'Update details for ' . $medication->name)

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
        <form action="{{ route('medications.update', $medication) }}" method="POST" class="glass-card p-8">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Name -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Medication Name</label>
                    <input type="text" name="name" class="input-field" value="{{ old('name', $medication->name) }}" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Dosage -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Dosage</label>
                    <input type="text" name="dosage" class="input-field" value="{{ old('dosage', $medication->dosage) }}" required>
                    @error('dosage') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Instructions -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Instructions</label>
                    <textarea name="instructions" rows="3" class="input-field">{{ old('instructions', $medication->instructions) }}</textarea>
                    @error('instructions') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div class="grid grid-cols-2 gap-6">
                    <!-- Total Stock -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Total Pack Size</label>
                        <input type="number" name="total_stock" class="input-field" min="1" value="{{ old('total_stock', $medication->total_stock) }}" required>
                        @error('total_stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Current Stock -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Current Combined Stock</label>
                        <input type="number" name="current_stock" class="input-field" min="0" value="{{ old('current_stock', $medication->current_stock) }}" required>
                        @error('current_stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-4">
                    <button type="submit" class="btn-primary">
                        Update Medication
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
