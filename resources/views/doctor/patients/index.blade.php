@extends('layouts.doctor')

@section('title', 'Directorio de Pacientes')

@section('breadcrumbs')
    <a href="{{ route('doctor.dashboard') }}" class="hover:text-primary transition-colors">Clínica</a>
    <span class="mx-2 text-slate-300">/</span>
    <span class="text-slate-800 dark:text-white font-medium">Pacientes</span>
@endsection

@section('content')
    <!-- Directory Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Directorio de Pacientes</h1>
        <p class="text-slate-500 text-sm mt-1">Panel de administración de pacientes de la clínica.</p>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-surface-light dark:bg-surface-dark p-4 rounded-xl shadow-sm border border-border-light dark:border-border-dark mb-6 flex flex-col md:flex-row gap-4 items-center">
        <button class="p-2 text-slate-500 hover:text-slate-700 border border-slate-200 rounded-lg">
            <span class="material-symbols-rounded">filter_list</span>
        </button>
        <div class="relative flex-1 w-full">
            <span class="material-symbols-rounded absolute left-3 top-3 text-slate-400">search</span>
            <input type="text" placeholder="Buscar pacientes..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary">
        </div>
    </div>

    <!-- Patients List -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-border-light dark:border-border-dark overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 dark:bg-slate-800/50">
                    <tr>
                        <th class="px-6 py-3 font-medium">Perfil</th>
                        <th class="px-6 py-3 font-medium">MRN</th>
                        <th class="px-6 py-3 font-medium">Diagnóstico Actual</th>
                        <th class="px-6 py-3 font-medium">Estado de Adherencia</th>
                        <th class="px-6 py-3 font-medium text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-light dark:divide-border-dark">
                    @foreach($patients as $patient)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img class="w-10 h-10 rounded-full object-cover border border-slate-200" src="{{ $patient->profile_photo_url }}" alt="{{ $patient->name }}">
                                <span class="font-bold text-slate-900 dark:text-white">{{ $patient->full_name ?? $patient->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-500 font-mono">
                            {{ $patient->mrn ?? '#---' }}
                        </td>
                        <td class="px-6 py-4 text-slate-700 dark:text-slate-300">
                            {{ $patient->diagnosis ?? 'Chequeo de Rutina' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($patient->adherence_score >= 80)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                    <span class="material-symbols-rounded text-[14px] mr-1">check_circle</span>
                                    Alta ({{ $patient->adherence_score }}%)
                                </span>
                            @elseif($patient->adherence_score >= 50)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 border border-amber-200">
                                    <span class="material-symbols-rounded text-[14px] mr-1">warning</span>
                                    Moderada ({{ $patient->adherence_score }}%)
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                    <span class="material-symbols-rounded text-[14px] mr-1">error</span>
                                    En Riesgo ({{ $patient->adherence_score }}%)
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('prescriptions.create') }}?patient_id={{ $patient->id }}" class="flex items-center gap-1 px-3 py-1.5 bg-primary hover:bg-primary-focus text-white text-xs font-medium rounded-lg transition-colors">
                                    <span class="material-symbols-rounded text-[16px]">edit_square</span>
                                    Recetar
                                </a>
                                <button class="flex items-center gap-1 px-3 py-1.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 text-xs font-medium rounded-lg transition-colors shadow-sm">
                                    <span class="material-symbols-rounded text-[16px]">history</span>
                                    Historial
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination (Mock) -->
        <div class="p-4 border-t border-border-light dark:border-border-dark flex justify-end gap-2">
            <button class="p-2 rounded-lg border border-slate-200 text-slate-400 hover:bg-slate-50 disabled:opacity-50" disabled>
                <span class="material-symbols-rounded text-[18px]">chevron_left</span>
            </button>
            <button class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 font-bold text-sm border border-blue-100">1</button>
            <button class="w-8 h-8 rounded-lg text-slate-500 hover:bg-slate-50 font-medium text-sm border border-transparent">2</button>
            <button class="w-8 h-8 rounded-lg text-slate-500 hover:bg-slate-50 font-medium text-sm border border-transparent">3</button>
            <button class="p-2 rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50">
                <span class="material-symbols-rounded text-[18px]">chevron_right</span>
            </button>
        </div>
    </div>
@endsection

@section('content')
    <!-- Directory Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Patient Directory</h1>
        <p class="text-slate-500 text-sm mt-1">Clinical patient directory dashboard.</p>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-surface-light dark:bg-surface-dark p-4 rounded-xl shadow-sm border border-border-light dark:border-border-dark mb-6 flex flex-col md:flex-row gap-4 items-center">
        <button class="p-2 text-slate-500 hover:text-slate-700 border border-slate-200 rounded-lg">
            <span class="material-symbols-rounded">filter_list</span>
        </button>
        <div class="relative flex-1 w-full">
            <span class="material-symbols-rounded absolute left-3 top-3 text-slate-400">search</span>
            <input type="text" placeholder="Search patients..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary">
        </div>
    </div>

    <!-- Patients List -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-border-light dark:border-border-dark overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 dark:bg-slate-800/50">
                    <tr>
                        <th class="px-6 py-3 font-medium">Profile</th>
                        <th class="px-6 py-3 font-medium">MRN</th>
                        <th class="px-6 py-3 font-medium">Current Diagnosis</th>
                        <th class="px-6 py-3 font-medium">Adherence Status</th>
                        <th class="px-6 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-light dark:divide-border-dark">
                    @foreach($patients as $patient)
                    <tr class="group hover:bg-blue-50/50 dark:hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img class="w-10 h-10 rounded-full object-cover border border-slate-200" src="{{ $patient->profile_photo_url }}" alt="{{ $patient->name }}">
                                <span class="font-bold text-slate-900 dark:text-white">{{ $patient->full_name ?? $patient->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-500 font-mono">
                            {{ $patient->mrn ?? '#---' }}
                        </td>
                        <td class="px-6 py-4 text-slate-700 dark:text-slate-300">
                            {{ $patient->diagnosis ?? 'Routine Checkup' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($patient->adherence_score >= 80)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                    <span class="material-symbols-rounded text-[14px] mr-1">check_circle</span>
                                    High Adherence ({{ $patient->adherence_score }}%)
                                </span>
                            @elseif($patient->adherence_score >= 50)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 border border-amber-200">
                                    <span class="material-symbols-rounded text-[14px] mr-1">warning</span>
                                    Moderate ({{ $patient->adherence_score }}%)
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                    <span class="material-symbols-rounded text-[14px] mr-1">error</span>
                                    At Risk (<50%)
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('prescriptions.create') }}?patient_id={{ $patient->id }}" class="flex items-center gap-1 px-3 py-1.5 bg-primary hover:bg-primary-focus text-white text-xs font-medium rounded-lg transition-colors">
                                    <span class="material-symbols-rounded text-[16px]">edit_square</span>
                                    Quick Prescribe
                                </a>
                                <button class="flex items-center gap-1 px-3 py-1.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 text-xs font-medium rounded-lg transition-colors shadow-sm">
                                    <span class="material-symbols-rounded text-[16px]">history</span>
                                    History
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination (Mock) -->
        <div class="p-4 border-t border-border-light dark:border-border-dark flex justify-end gap-2">
            <button class="p-2 rounded-lg border border-slate-200 text-slate-400 hover:bg-slate-50 disabled:opacity-50" disabled>
                <span class="material-symbols-rounded text-[18px]">chevron_left</span>
            </button>
            <button class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 font-bold text-sm border border-blue-100">1</button>
            <button class="w-8 h-8 rounded-lg text-slate-500 hover:bg-slate-50 font-medium text-sm border border-transparent">2</button>
            <button class="w-8 h-8 rounded-lg text-slate-500 hover:bg-slate-50 font-medium text-sm border border-transparent">3</button>
            <button class="p-2 rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50">
                <span class="material-symbols-rounded text-[18px]">chevron_right</span>
            </button>
        </div>
    </div>
@endsection
