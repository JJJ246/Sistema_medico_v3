<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalles de la Receta') }} #{{ $prescription->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">¡Éxito!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Información de la Receta</h3>
                        <a href="{{ route('prescriptions.download', $prescription) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                            <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/></svg>
                            <span>Descargar PDF</span>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Detalles del Médico y Paciente -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-700 mb-2 border-b pb-2">Datos Generales</h4>
                            <p><strong>Doctor:</strong> {{ $prescription->doctor->name }}</p>
                            <p><strong>Paciente:</strong> {{ $prescription->patient->name }}</p>
                            <p><strong>Fecha de Emisión:</strong> {{ $prescription->created_at->format('d/m/Y H:i') }}</p>
                        </div>

                        <!-- Detalles del Medicamento -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-700 mb-2 border-b pb-2">Medicamento</h4>
                            <p class="text-xl text-blue-600 font-bold">{{ $prescription->medication->name }}</p>
                            <p><strong>Frecuencia:</strong> {{ $prescription->frequency }}</p>
                            <p><strong>Duración:</strong> {{ $prescription->duration_days }} días</p>
                            <p><strong>Cantidad Total:</strong> {{ $prescription->total_quantity }}</p>
                        </div>
                    </div>

                    <div class="mt-6 bg-yellow-50 p-4 rounded-lg border-l-4 border-yellow-400">
                        <h4 class="font-semibold text-yellow-700 mb-2">Instrucciones</h4>
                        <p class="text-gray-700 italic">"{{ $prescription->instructions ?? 'Sin instrucciones específicas.' }}"</p>
                    </div>

                    <div class="mt-8 flex justify-end gap-2">
                        <a href="{{ route('prescriptions.index') }}" class="text-gray-600 hover:text-gray-900 font-medium overflow-hidden">
                            &larr; Volver al Historial
                        </a>
                        <a href="{{ route('prescriptions.create') }}" class="text-blue-600 hover:text-blue-900 font-medium ml-4">
                            Emitir Nueva Receta &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
