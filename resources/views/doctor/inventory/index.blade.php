@extends('layouts.doctor')

@section('title', 'Inventario de Farmacia')

@section('breadcrumbs')
    <a href="{{ route('doctor.dashboard') }}" class="hover:text-primary transition-colors">Gestión</a>
    <span class="mx-2 text-slate-300">/</span>
    <span class="text-slate-800 dark:text-white font-medium">Inventario</span>
@endsection

@section('content')
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Sistema de Gestión de Inventario</h1>
        <a href="{{ route('doctor.inventory.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-colors flex items-center gap-2">
            <span class="material-symbols-rounded">add</span>
            Nuevo Medicamento
        </a>
    </div>

    <!-- Stats Overview -->
    <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-2xl shadow-sm border border-border-light dark:border-border-dark mb-8 flex flex-col md:flex-row gap-8 md:gap-16">
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Valor Total del Inventario</p>
            <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white mt-1">${{ number_format($totalValue, 2) }}</h2>
        </div>
        <div class="h-auto w-px bg-slate-200 dark:bg-slate-700 hidden md:block"></div>
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Alertas Críticas</p>
            <h2 class="text-3xl font-extrabold text-red-500 mt-1">{{ $criticalCount }}</h2>
        </div>
    </div>

    <!-- Inventory Table -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-border-light dark:border-border-dark overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 dark:bg-slate-800/50">
                    <tr>
                        <th class="px-6 py-4 font-medium">Medicamento</th>
                        <th class="px-6 py-4 font-medium">SKU</th>
                        <th class="px-6 py-4 font-medium">Precio</th>
                        <th class="px-6 py-4 font-medium">Stock</th>
                        <th class="px-6 py-4 font-medium text-right">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-light dark:divide-border-dark">
                    @foreach($medications as $medication)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/20 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">
                            {{ $medication->name }} {{ $medication->dosage }}
                        </td>
                        <td class="px-6 py-4 text-slate-500 font-mono">
                            MED-{{ str_pad($medication->id, 3, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-6 py-4 text-slate-700 dark:text-slate-300">
                            $0.50
                        </td>
                        <td class="px-6 py-4">
                            @if($medication->current_stock <= 10)
                                <div>
                                    <span class="inline-block px-2 py-1 bg-amber-500 text-white text-xs font-bold rounded">Stock: {{ $medication->current_stock }}</span>
                                    <div class="text-xs text-amber-500 font-bold mt-1 flex items-center gap-1">
                                        <span class="material-symbols-rounded text-[14px]">warning</span> Stock Bajo
                                    </div>
                                </div>
                            @else
                                <span class="font-medium text-slate-700 dark:text-slate-300">Stock: {{ $medication->current_stock }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('doctor.inventory.add', $medication->id) }}" method="POST" class="flex items-center justify-end gap-2">
                                @csrf
                                <input type="number" name="quantity" class="w-20 px-2 py-1 text-xs border border-slate-300 rounded focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-slate-800 dark:border-slate-600 dark:text-white" placeholder="Cant" min="1" value="10">
                                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded transition-colors shadow-sm whitespace-nowrap">
                                    Agregar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Pharmacy Inventory Management System</h1>
    </div>

    <!-- Stats Overview -->
    <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-2xl shadow-sm border border-border-light dark:border-border-dark mb-8 flex flex-col md:flex-row gap-8 md:gap-16">
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Inventory Value</p>
            <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white mt-1">${{ number_format($totalValue, 2) }}</h2>
        </div>
        <div class="h-auto w-px bg-slate-200 dark:bg-slate-700 hidden md:block"></div>
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Critical Alerts</p>
            <h2 class="text-3xl font-extrabold text-red-500 mt-1">{{ $criticalCount }}</h2>
        </div>
    </div>

    <!-- Inventory Table -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-border-light dark:border-border-dark overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 dark:bg-slate-800/50">
                    <tr>
                        <th class="px-6 py-4 font-medium">Medication</th>
                        <th class="px-6 py-4 font-medium">SKU</th>
                        <th class="px-6 py-4 font-medium">Price</th>
                        <th class="px-6 py-4 font-medium">Current Stock</th>
                        <th class="px-6 py-4 font-medium text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-light dark:divide-border-dark">
                    @foreach($medications as $medication)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/20 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">
                            {{ $medication->name }} {{ $medication->dosage }}
                        </td>
                        <td class="px-6 py-4 text-slate-500 font-mono">
                            MED-{{ str_pad($medication->id, 3, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-6 py-4 text-slate-700 dark:text-slate-300">
                            $0.50
                        </td>
                        <td class="px-6 py-4">
                            @if($medication->current_stock <= 10)
                                <div>
                                    <span class="inline-block px-2 py-1 bg-amber-500 text-white text-xs font-bold rounded">Current Stock: {{ $medication->current_stock }}</span>
                                    <div class="text-xs text-amber-500 font-bold mt-1 flex items-center gap-1">
                                        <span class="material-symbols-rounded text-[14px]">warning</span> Low Stock
                                    </div>
                                </div>
                            @else
                                <span class="font-medium text-slate-700 dark:text-slate-300">Current Stock: {{ $medication->current_stock }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('doctor.inventory.add', $medication->id) }}" method="POST" class="flex items-center justify-end gap-2">
                                @csrf
                                <input type="number" name="quantity" class="w-20 px-2 py-1 text-xs border border-slate-300 rounded focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-slate-800 dark:border-slate-600 dark:text-white" placeholder="Qty" min="1" value="10">
                                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded transition-colors shadow-sm whitespace-nowrap">
                                    Add Stock
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
