@extends((auth()->user()->role === 'doctor' || auth()->user()->role === 'admin') ? 'layouts.doctor' : 'layouts.patient')

@section('title', 'Historial de Recetas')
@section('header_title', 'Historial de Recetas')
@section('header_subtitle', 'Consulta y descarga tus recetas médicas')

@section('content')
<div class="space-y-6">
            
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 px-4 sm:px-0">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Mis Recetas</h3>
                    <p class="text-slate-500 text-sm">Consulta y descarga tu historial de prescripciones médicas.</p>
                </div>
                @if(auth()->user()->role === 'doctor' || auth()->user()->role === 'admin')
                    <a href="{{ route('prescriptions.create') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-primary-focus text-white font-bold py-2.5 px-5 rounded-xl shadow-lg shadow-primary/30 transition-all transform hover:-translate-y-0.5">
                        <span class="material-symbols-rounded">add_circle</span>
                        Nueva Receta
                    </a>
                @endif
            </div>

            @if($prescriptions->isEmpty())
                <div class="flex flex-col items-center justify-center py-20 bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 text-center mx-4 sm:mx-0">
                    <div class="w-24 h-24 bg-slate-50 dark:bg-slate-700 rounded-full flex items-center justify-center mb-6">
                        <span class="material-symbols-rounded text-6xl text-slate-300 dark:text-slate-500">receipt_long</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white">No hay recetas registradas</h3>
                    <p class="text-slate-500 mt-2 max-w-sm">Aún no tienes prescripciones en tu historial. Las nuevas recetas aparecerán aquí.</p>
                </div>
            @else
                <!-- Timeline/Card Grid Layout -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-4 sm:px-0">
                    @foreach($prescriptions as $prescription)
                        <div class="bg-white dark:bg-surface-dark rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden hover:shadow-xl hover:border-primary/30 transition-all duration-300 group">
                            <!-- Card Header: Medication & Date -->
                            <div class="p-6 border-b border-slate-100 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/30">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                                        <span class="material-symbols-rounded text-3xl">pill</span>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Fecha</span>
                                        <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $prescription->created_at->format('d M, Y') }}</span>
                                    </div>
                                </div>
                                <h4 class="text-lg font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors">
                                    {{ $prescription->medication->name }}
                                </h4>
                                <p class="text-sm text-slate-500 truncate mt-1">{{ $prescription->frequency }}</p>
                            </div>

                            <!-- Card Body: User Info -->
                            <div class="p-6">
                                <div class="flex items-center gap-3 mb-6">
                                    @if(auth()->user()->role === 'doctor' || auth()->user()->role === 'admin')
                                        <img class="w-10 h-10 rounded-full object-cover border-2 border-slate-100" src="{{ $prescription->patient->profile_photo_url }}" alt="{{ $prescription->patient->name }}">
                                        <div>
                                            <p class="text-xs text-slate-500 uppercase font-bold">Paciente</p>
                                            <p class="text-sm font-semibold text-slate-800 dark:text-slate-200 line-clamp-1">{{ $prescription->patient->name }}</p>
                                        </div>
                                    @else
                                        <img class="w-10 h-10 rounded-full object-cover border-2 border-slate-100" src="{{ $prescription->doctor->profile_photo_url }}" alt="{{ $prescription->doctor->name }}">
                                        <div>
                                            <p class="text-xs text-slate-500 uppercase font-bold">Doctor</p>
                                            <p class="text-sm font-semibold text-slate-800 dark:text-slate-200 line-clamp-1">Dr. {{ $prescription->doctor->name }}</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Actions -->
                                <div class="flex gap-3">
                                    <a href="{{ route('prescriptions.show', $prescription) }}" class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-300 font-semibold text-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                        <span class="material-symbols-rounded text-lg">visibility</span>
                                        Ver Detalles
                                    </a>
                                    <a href="{{ route('prescriptions.download', $prescription) }}" class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-semibold text-sm hover:bg-slate-700 dark:hover:bg-slate-200 shadow-lg shadow-slate-200 dark:shadow-none transition-all">
                                        <span class="material-symbols-rounded text-lg">download</span>
                                        PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 px-4 sm:px-0">
                    {{ $prescriptions->links() }} 
                </div>
            @endif
        </div>
    </div>
@endsection
