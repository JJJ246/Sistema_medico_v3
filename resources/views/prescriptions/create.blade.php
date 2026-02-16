@extends('layouts.doctor')

@section('title', 'Crear Nueva Receta')

@section('breadcrumbs')
    <a href="{{ route('doctor.dashboard') }}" class="hover:text-primary transition-colors">Recetas</a>
    <span class="mx-2 text-slate-300">/</span>
    <span class="text-slate-800 dark:text-white font-medium">Crear Nueva</span>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form Section -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Nueva Receta</h1>
                    <p class="text-slate-500 text-sm mt-1">Emitir una nueva orden de medicación para un paciente.</p>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-border-light dark:border-border-dark p-6">
                <form action="{{ route('prescriptions.store') }}" method="POST" class="space-y-6" id="prescriptionForm">
                    @csrf
                    
                    <!-- Patient Selection -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Seleccionar Paciente</label>
                        <div class="relative group">
                            <span class="material-symbols-rounded absolute left-3 top-3 text-slate-400 group-focus-within:text-primary transition-colors">person_search</span>
                            <select name="patient_id" class="filament-input w-full pl-10 pr-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-900 dark:text-white transition-all duration-200 appearance-none focus:ring-0">
                                <option value="" disabled selected>Buscar por nombre, MRN o fecha de nacimiento...</option>
                                @foreach(\App\Models\User::where('role', 'patient')->get() as $patient)
                                    <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                                        {{ $patient->name }} (MRN: {{ $patient->mrn }})
                                    </option>
                                @endforeach
                            </select>
                            <span class="material-symbols-rounded absolute right-3 top-3 text-slate-400 pointer-events-none">expand_more</span>
                        </div>
                    </div>

                    <hr class="border-slate-100 dark:border-slate-800"/>

                    <!-- Medication Selection -->
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Medication Dropdown -->
                            <div class="space-y-2 md:col-span-2">
                                <div class="flex justify-between items-center">
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Medicamento</label>
                                </div>
                                <div class="relative">
                                    <span class="material-symbols-rounded absolute left-3 top-3 text-slate-400">medication</span>
                                    <select name="medication_id" class="filament-input w-full pl-10 pr-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-900 dark:text-white shadow-sm appearance-none focus:ring-0" onchange="checkStock(this)">
                                        <option value="" disabled selected>Seleccionar Medicamento...</option>
                                        @foreach(\App\Models\Medication::all() as $medication)
                                            <option value="{{ $medication->id }}" data-stock="{{ $medication->current_stock }}">
                                                {{ $medication->name }} - {{ $medication->dosage }} (Stock: {{ $medication->current_stock }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="material-symbols-rounded absolute right-3 top-3 text-slate-400 pointer-events-none">expand_more</span>
                                </div>
                                <div id="stockWarning" class="hidden mt-1 text-xs text-amber-600 dark:text-amber-400 flex items-center gap-1 bg-amber-50 dark:bg-amber-900/20 px-2 py-0.5 rounded-md border border-amber-100 dark:border-amber-900/30 w-fit">
                                    <span class="material-symbols-rounded text-[14px]">warning</span>
                                    <span>Stock Bajo</span>
                                </div>
                            </div>

                            <!-- Frequency -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Frecuencia</label>
                                <div class="relative">
                                    <select name="frequency" class="filament-input appearance-none w-full pl-4 pr-10 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-0">
                                        <option value="q8h">Cada 8 horas (q8h)</option>
                                        <option value="q12h">Cada 12 horas (q12h)</option>
                                        <option value="daily">Una vez al día (QD)</option>
                                        <option value="bid">Dos veces al día (BID)</option>
                                        <option value="tid">Tres veces al día (TID)</option>
                                    </select>
                                    <span class="material-symbols-rounded absolute right-3 top-3 text-slate-400 pointer-events-none text-[20px]">expand_more</span>
                                </div>
                            </div>

                            <!-- Duration -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Duración</label>
                                <div class="flex shadow-sm rounded-lg">
                                    <input name="duration_days" class="filament-input flex-1 rounded-l-lg border border-r-0 border-slate-200 dark:border-slate-700 px-3 py-2.5 text-sm bg-white dark:bg-slate-800/50 dark:text-white focus:z-10 focus:ring-0" type="number" value="7" min="1"/>
                                    <select class="filament-input w-24 rounded-r-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 px-3 py-2.5 text-sm text-slate-600 dark:text-slate-300 focus:z-10 focus:ring-0">
                                        <option value="days">Días</option>
                                        <option value="weeks">Semanas</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Quantity Calculation Display (Read Only) -->
                        <div class="bg-slate-50 dark:bg-slate-800/50 rounded-lg p-3 flex justify-between items-center border border-slate-100 dark:border-slate-800">
                            <span class="text-xs text-slate-500 font-medium uppercase tracking-wide">Cantidad Total a Dispensar</span>
                            <span class="text-sm font-bold text-slate-800 dark:text-slate-200">Calculado al emitir</span>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Instrucciones Adicionales</label>
                        <textarea name="instructions" class="filament-input w-full p-3 bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:ring-0" placeholder="ej. Tomar con alimentos. No operar maquinaria pesada." rows="3"></textarea>
                        <div class="flex gap-2 mt-2">
                            <button class="text-xs bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-400 px-2 py-1 rounded transition-colors" type="button" onclick="setInstruction('Tomar con alimentos.')">Tomar con alimentos</button>
                            <button class="text-xs bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-400 px-2 py-1 rounded transition-colors" type="button" onclick="setInstruction('Tomar antes de dormir.')">Antes de dormir</button>
                            <button class="text-xs bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-400 px-2 py-1 rounded transition-colors" type="button" onclick="setInstruction('Completar todo el tratamiento.')">Completar tratamiento</button>
                        </div>
                    </div>

                    <!-- Action Bar -->
                    <div class="flex items-center justify-between pt-2">
                        <a href="{{ route('doctor.dashboard') }}" class="text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 font-medium text-sm transition-colors">Cancelar</a>
                        <div class="flex items-center gap-3">
                            <button type="button" class="px-4 py-2 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-medium text-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm">Guardar Borrador</button>
                            <button type="submit" class="px-4 py-2 rounded-lg bg-primary hover:bg-primary-focus text-white font-medium text-sm shadow-lg shadow-primary/30 transition-all flex items-center gap-2">
                                <span class="material-symbols-rounded text-[18px]">send</span>
                                Emitir Receta
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar: Schedule Preview & Info -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Schedule Card -->
            <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-border-light dark:border-border-dark overflow-hidden flex flex-col h-full max-h-[600px]">
                <div class="p-4 border-b border-border-light dark:border-border-dark bg-slate-50/50 dark:bg-slate-800/50 backdrop-blur-sm">
                    <h3 class="font-semibold text-slate-800 dark:text-white flex items-center gap-2">
                        <span class="material-symbols-rounded text-primary">schedule</span>
                        Vista Previa del Horario
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">Dosificación proyectada según frecuencia.</p>
                </div>
                <div class="p-4 flex-1 overflow-y-auto">
                    <!-- Timeline -->
                    <div class="relative pl-4 border-l-2 border-slate-100 dark:border-slate-800 space-y-6 my-2">
                        <!-- Dose 1 -->
                        <div class="relative group">
                            <div class="absolute -left-[21px] top-1 h-3 w-3 rounded-full border-2 border-primary bg-white dark:bg-slate-900 group-hover:scale-125 transition-transform"></div>
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-primary uppercase tracking-wider">Primera Dosis - Hoy</span>
                                <span class="text-sm font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ now()->format('h:i A') }}</span>
                                <span class="text-xs text-slate-500">Al Emitir</span>
                            </div>
                        </div>
                        <!-- Dose 2 -->
                        <div class="relative group">
                            <div class="absolute -left-[21px] top-1 h-3 w-3 rounded-full border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 group-hover:border-primary transition-colors"></div>
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Dosis 2</span>
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300 mt-0.5">Calculado automáticamente</span>
                            </div>
                        </div>
                        <!-- Indicator for more -->
                        <div class="relative">
                            <div class="absolute -left-[20px] top-2 h-1.5 w-1.5 rounded-full bg-slate-200 dark:bg-slate-700"></div>
                            <div class="absolute -left-[20px] top-5 h-1.5 w-1.5 rounded-full bg-slate-200 dark:bg-slate-700"></div>
                            <span class="text-xs text-slate-400 pl-2 italic">...continúa por la duración</span>
                        </div>
                    </div>
                    
                    <!-- Alert Section -->
                    <div class="bg-blue-50 dark:bg-blue-900/10 p-4 border-t border-blue-100 dark:border-blue-900/30 mt-4 rounded-lg">
                        <div class="flex gap-3">
                            <span class="material-symbols-rounded text-blue-600 dark:text-blue-400 mt-0.5">info</span>
                            <div class="text-xs text-blue-800 dark:text-blue-300">
                                <p class="font-semibold mb-1">Chequeo de Interacción</p>
                                <p class="opacity-80">El sistema verificará interacciones automáticamente.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Mini Patient Summary Card -->
            @if(request('patient_id'))
                @php
                    $selectedPatient = \App\Models\User::find(request('patient_id'));
                @endphp
                <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-border-light dark:border-border-dark p-4">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-lg">
                            {{ substr($selectedPatient->name, 0, 2) }}
                        </div>
                        <div class="overflow-hidden">
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white truncate">{{ $selectedPatient->name }}</h4>
                            <span class="text-xs text-slate-500">MRN: {{ $selectedPatient->mrn ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function setInstruction(text) {
            document.querySelector('textarea[name=instructions]').value = text;
        }

        function checkStock(select) {
            const option = select.options[select.selectedIndex];
            const stock = option.getAttribute('data-stock');
            const warning = document.querySelector('#stockWarning');
            const label = warning.querySelector('span:last-child');
            
            if (stock && stock < 20) {
                warning.classList.remove('hidden');
                label.textContent = 'Stock Bajo: ' + stock + ' unidades restantes';
            } else {
                warning.classList.add('hidden');
            }
        }
    </script>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form Section -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-white">New Prescription</h1>
                    <p class="text-slate-500 text-sm mt-1">Issue a new medication order for a patient.</p>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-border-light dark:border-border-dark p-6">
                <form action="{{ route('prescriptions.store') }}" method="POST" class="space-y-6" id="prescriptionForm">
                    @csrf
                    
                    <!-- Patient Selection -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Select Patient</label>
                        <div class="relative group">
                            <span class="material-symbols-rounded absolute left-3 top-3 text-slate-400 group-focus-within:text-primary transition-colors">person_search</span>
                            <select name="patient_id" class="filament-input w-full pl-10 pr-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-900 dark:text-white transition-all duration-200 appearance-none focus:ring-0">
                                <option value="" disabled selected>Search by name, MRN, or DOB...</option>
                                @foreach(\App\Models\User::where('role', 'patient')->get() as $patient)
                                    <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                                        {{ $patient->name }} (MRN: {{ $patient->mrn }})
                                    </option>
                                @endforeach
                            </select>
                            <span class="material-symbols-rounded absolute right-3 top-3 text-slate-400 pointer-events-none">expand_more</span>
                        </div>
                    </div>

                    <hr class="border-slate-100 dark:border-slate-800"/>

                    <!-- Medication Selection -->
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Medication Dropdown -->
                            <div class="space-y-2 md:col-span-2">
                                <div class="flex justify-between items-center">
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Medication</label>
                                    @// We can inject low stock warnings via JS here later, but for now typical static behavior
                                </div>
                                <div class="relative">
                                    <span class="material-symbols-rounded absolute left-3 top-3 text-slate-400">medication</span>
                                    <select name="medication_id" class="filament-input w-full pl-10 pr-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-900 dark:text-white shadow-sm appearance-none focus:ring-0" onchange="checkStock(this)">
                                        <option value="" disabled selected>Select Medication...</option>
                                        @foreach(\App\Models\Medication::all() as $medication)
                                            <option value="{{ $medication->id }}" data-stock="{{ $medication->current_stock }}">
                                                {{ $medication->name }} - {{ $medication->dosage }} (Stock: {{ $medication->current_stock }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="material-symbols-rounded absolute right-3 top-3 text-slate-400 pointer-events-none">expand_more</span>
                                </div>
                                <div id="stockWarning" class="hidden mt-1 text-xs text-amber-600 dark:text-amber-400 flex items-center gap-1 bg-amber-50 dark:bg-amber-900/20 px-2 py-0.5 rounded-md border border-amber-100 dark:border-amber-900/30 w-fit">
                                    <span class="material-symbols-rounded text-[14px]">warning</span>
                                    <span>Low Stock</span>
                                </div>
                            </div>

                            <!-- Frequency -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Frequency</label>
                                <div class="relative">
                                    <select name="frequency" class="filament-input appearance-none w-full pl-4 pr-10 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-0">
                                        <option value="q8h">Every 8 hours (q8h)</option>
                                        <option value="q12h">Every 12 hours (q12h)</option>
                                        <option value="daily">Once daily (QD)</option>
                                        <option value="bid">Twice daily (BID)</option>
                                        <option value="tid">Three times daily (TID)</option>
                                    </select>
                                    <span class="material-symbols-rounded absolute right-3 top-3 text-slate-400 pointer-events-none text-[20px]">expand_more</span>
                                </div>
                            </div>

                            <!-- Duration -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Duration</label>
                                <div class="flex shadow-sm rounded-lg">
                                    <input name="duration_days" class="filament-input flex-1 rounded-l-lg border border-r-0 border-slate-200 dark:border-slate-700 px-3 py-2.5 text-sm bg-white dark:bg-slate-800/50 dark:text-white focus:z-10 focus:ring-0" type="number" value="7" min="1"/>
                                    <select class="filament-input w-24 rounded-r-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 px-3 py-2.5 text-sm text-slate-600 dark:text-slate-300 focus:z-10 focus:ring-0">
                                        <option value="days">Days</option>
                                        <option value="weeks">Weeks</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Quantity Calculation Display (Read Only) -->
                        <div class="bg-slate-50 dark:bg-slate-800/50 rounded-lg p-3 flex justify-between items-center border border-slate-100 dark:border-slate-800">
                            <span class="text-xs text-slate-500 font-medium uppercase tracking-wide">Total Quantity to Dispense</span>
                            <span class="text-sm font-bold text-slate-800 dark:text-slate-200">Calculated upon issuance</span>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Additional Instructions</label>
                        <textarea name="instructions" class="filament-input w-full p-3 bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:ring-0" placeholder="e.g. Take with food. Do not operate heavy machinery." rows="3"></textarea>
                        <div class="flex gap-2 mt-2">
                            <button class="text-xs bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-400 px-2 py-1 rounded transition-colors" type="button" onclick="setInstruction('Take with food.')">Take with food</button>
                            <button class="text-xs bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-400 px-2 py-1 rounded transition-colors" type="button" onclick="setInstruction('Take before bed.')">Before bed</button>
                            <button class="text-xs bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-400 px-2 py-1 rounded transition-colors" type="button" onclick="setInstruction('Finish full course.')">Finish full course</button>
                        </div>
                    </div>

                    <!-- Action Bar -->
                    <div class="flex items-center justify-between pt-2">
                        <a href="{{ route('doctor.dashboard') }}" class="text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 font-medium text-sm transition-colors">Cancel</a>
                        <div class="flex items-center gap-3">
                            <button type="button" class="px-4 py-2 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-medium text-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm">Save Draft</button>
                            <button type="submit" class="px-4 py-2 rounded-lg bg-primary hover:bg-primary-focus text-white font-medium text-sm shadow-lg shadow-primary/30 transition-all flex items-center gap-2">
                                <span class="material-symbols-rounded text-[18px]">send</span>
                                Issue Prescription
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar: Schedule Preview & Info -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Schedule Card -->
            <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-border-light dark:border-border-dark overflow-hidden flex flex-col h-full max-h-[600px]">
                <div class="p-4 border-b border-border-light dark:border-border-dark bg-slate-50/50 dark:bg-slate-800/50 backdrop-blur-sm">
                    <h3 class="font-semibold text-slate-800 dark:text-white flex items-center gap-2">
                        <span class="material-symbols-rounded text-primary">schedule</span>
                        Preview Schedule
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">Projected dosing based on frequency.</p>
                </div>
                <div class="p-4 flex-1 overflow-y-auto">
                    <!-- Timeline -->
                    <div class="relative pl-4 border-l-2 border-slate-100 dark:border-slate-800 space-y-6 my-2">
                        <!-- Dose 1 -->
                        <div class="relative group">
                            <div class="absolute -left-[21px] top-1 h-3 w-3 rounded-full border-2 border-primary bg-white dark:bg-slate-900 group-hover:scale-125 transition-transform"></div>
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-primary uppercase tracking-wider">First Dose - Today</span>
                                <span class="text-sm font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ now()->format('h:i A') }}</span>
                                <span class="text-xs text-slate-500">Upon Issuance</span>
                            </div>
                        </div>
                        <!-- Dose 2 -->
                        <div class="relative group">
                            <div class="absolute -left-[21px] top-1 h-3 w-3 rounded-full border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 group-hover:border-primary transition-colors"></div>
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Dose 2</span>
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300 mt-0.5">Calculated automatically</span>
                            </div>
                        </div>
                        <!-- Indicator for more -->
                        <div class="relative">
                            <div class="absolute -left-[20px] top-2 h-1.5 w-1.5 rounded-full bg-slate-200 dark:bg-slate-700"></div>
                            <div class="absolute -left-[20px] top-5 h-1.5 w-1.5 rounded-full bg-slate-200 dark:bg-slate-700"></div>
                            <span class="text-xs text-slate-400 pl-2 italic">...continues for duration</span>
                        </div>
                    </div>
                    
                    <!-- Alert Section -->
                    <div class="bg-blue-50 dark:bg-blue-900/10 p-4 border-t border-blue-100 dark:border-blue-900/30 mt-4 rounded-lg">
                        <div class="flex gap-3">
                            <span class="material-symbols-rounded text-blue-600 dark:text-blue-400 mt-0.5">info</span>
                            <div class="text-xs text-blue-800 dark:text-blue-300">
                                <p class="font-semibold mb-1">Drug Interaction Check</p>
                                <p class="opacity-80">System will check for interactions automatically.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Mini Patient Summary Card -->
            @if(request('patient_id'))
                @php
                    $selectedPatient = \App\Models\User::find(request('patient_id'));
                @endphp
                <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-border-light dark:border-border-dark p-4">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-lg">
                            {{ substr($selectedPatient->name, 0, 2) }}
                        </div>
                        <div class="overflow-hidden">
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white truncate">{{ $selectedPatient->name }}</h4>
                            <span class="text-xs text-slate-500">MRN: {{ $selectedPatient->mrn ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function setInstruction(text) {
            document.querySelector('textarea[name=instructions]').value = text;
        }

        function checkStock(select) {
            const option = select.options[select.selectedIndex];
            const stock = option.getAttribute('data-stock');
            const warning = document.querySelector('#stockWarning');
            const label = warning.querySelector('span:last-child');
            
            if (stock && stock < 20) {
                warning.classList.remove('hidden');
                label.textContent = 'Low Stock: ' + stock + ' units remaining';
            } else {
                warning.classList.add('hidden');
            }
        }
    </script>
@endsection
