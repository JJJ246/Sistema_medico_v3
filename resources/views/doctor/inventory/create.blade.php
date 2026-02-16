@extends('layouts.doctor')

@section('title', 'Agregar Medicamento - Inventario')

@section('breadcrumbs')
    <a href="{{ route('doctor.dashboard') }}" class="hover:text-primary transition-colors">Gestión</a>
    <span class="mx-2 text-slate-300">/</span>
    <a href="{{ route('doctor.inventory') }}" class="hover:text-primary transition-colors">Inventario</a>
    <span class="mx-2 text-slate-300">/</span>
    <span class="text-slate-800 dark:text-white font-medium">Agregar Medicamento</span>
@endsection

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Agregar Nuevo Medicamento</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-1">Ingresa los detalles del nuevo medicamento para el inventario.</p>
    </div>

    <div class="max-w-3xl mx-auto">
        <div class="bg-surface-light dark:bg-surface-dark p-8 rounded-2xl shadow-sm border border-border-light dark:border-border-dark">
            <form action="{{ route('doctor.inventory.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Name -->
                    <div class="col-span-2">
                        <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nombre del Medicamento</label>
                        <input type="text" name="name" id="name" required 
                            class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors dark:text-white"
                            placeholder="Ej. Amoxicilina">
                    </div>

                    <!-- SKU -->
                    <div>
                        <label for="sku" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">SKU (Código Único)</label>
                        <input type="text" name="sku" id="sku" required 
                            class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors dark:text-white"
                            placeholder="Ej. MED-007">
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Precio ($)</label>
                        <input type="number" step="0.01" name="price" id="price" required 
                            class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors dark:text-white"
                            placeholder="0.00">
                    </div>

                    <!-- Dosage -->
                    <div>
                        <label for="dosage" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Dosis</label>
                        <input type="text" name="dosage" id="dosage" required 
                            class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors dark:text-white"
                            placeholder="Ej. 500mg">
                    </div>

                    <!-- Color Code -->
                    <div>
                        <label for="color_code" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Color Identificador</label>
                        <input type="color" name="color_code" id="color_code" value="#3b82f6" 
                            class="w-full h-10 p-1 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg cursor-pointer">
                    </div>

                    <!-- Stocks -->
                    <div>
                        <label for="total_stock" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Stock Total (Capacidad)</label>
                        <input type="number" name="total_stock" id="total_stock" required min="1"
                            class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors dark:text-white"
                            placeholder="Ej. 100">
                    </div>

                    <div>
                        <label for="current_stock" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Stock Inicial</label>
                        <input type="number" name="current_stock" id="current_stock" required min="0"
                            class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors dark:text-white"
                            placeholder="Ej. 50">
                    </div>
                     <!-- Threshold Alert -->
                     <div class="col-span-2">
                        <label for="threshold_alert" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Alerta de Stock Bajo (Cantidad)</label>
                        <input type="number" name="threshold_alert" id="threshold_alert" required min="1" value="10"
                            class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors dark:text-white"
                            placeholder="Ej. 10">
                        <p class="text-xs text-slate-500 mt-1">Se mostrará una alerta cuando el stock sea menor a este número.</p>
                    </div>

                    <!-- Instructions -->
                    <div class="col-span-2">
                        <label for="instructions" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Instrucciones / Notas</label>
                        <textarea name="instructions" id="instructions" rows="3"
                            class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors dark:text-white"
                            placeholder="Instrucciones de uso o notas sobre el medicamento..."></textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('doctor.inventory') }}" class="px-6 py-2.5 text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-primary-dark text-white font-bold rounded-lg shadow-lg shadow-primary/30 transition-all transform hover:scale-[1.02]">
                        Guardar Medicamento
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
