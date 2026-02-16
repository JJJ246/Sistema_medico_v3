<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\Medication;
use App\Models\User;

class PrescriptionController extends Controller
{
    /**
     * Show the form for creating a new prescription.
     */
    public function create()
    {
        return view('prescriptions.create');
    }

    /**
     * Issue a new prescription and deduct stock.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'medication_id' => 'required|exists:medications,id',
            'frequency' => 'required|string',
            'duration_days' => 'required|integer|min:1|max:365',
            'instructions' => 'nullable|string|max:500',
        ]);

        // 1. DEDUCT FROM INVENTORY (Admin/Doctor's Stock)
        $inventoryMedication = Medication::find($validated['medication_id']);
        
        // Calculate total quantity needed
        $tempPrescription = new Prescription($validated);
        $tempPrescription->calculateTotalQuantity();
        $totalQuantity = $tempPrescription->total_quantity;

        // Check stock
        if ($inventoryMedication->current_stock < $totalQuantity) {
             return back()->withErrors(['medication_id' => "Stock insuficiente. Disponible: {$inventoryMedication->current_stock}, Requerido: {$totalQuantity}"]);
        }

        $inventoryMedication->deductStock($totalQuantity);

        // 2. CREATE PRESCRIPTION RECORD
        $prescription = Prescription::create([
            'doctor_id' => auth()->id(),
            'patient_id' => $validated['patient_id'],
            'medication_id' => $validated['medication_id'],
            'frequency' => $validated['frequency'],
            'duration_days' => $validated['duration_days'],
            'instructions' => $validated['instructions'] ?? null,
            'total_quantity' => $totalQuantity
        ]);

        // 3. SYNCHRONIZE WITH PATIENT'S DASHBOARD (Clone Medication + Create Schedules)
        $this->syncToPatient($prescription, $inventoryMedication);

        return redirect()->route('prescriptions.show', $prescription)->with('success', 
            "¡Receta emitida con éxito! Stock descontado: {$totalQuantity} unidades. ID de Receta: #{$prescription->id}"
        );
    }

    /**
     * Helper to clone medication for patient and create schedules.
     */
    private function syncToPatient(Prescription $prescription, Medication $inventoryMed)
    {
        // A. Create/Find Patient's Copy of Medication
        // Check if patient already has this med (by SKU or Name)
        $patientMed = Medication::where('user_id', $prescription->patient_id)
            ->where(function($q) use ($inventoryMed) {
                if ($inventoryMed->sku) {
                    $q->where('sku', $inventoryMed->sku);
                } else {
                    $q->where('name', $inventoryMed->name);
                }
            })->first();

        if (!$patientMed) {
            // Append PATIENT-ID to SKU to avoid unique constraint
            $patientSku = $inventoryMed->sku . '-PAT-' . $prescription->patient_id;

            $patientMed = Medication::create([
                'user_id' => $prescription->patient_id,
                'name' => $inventoryMed->name,
                'sku' => $patientSku, 
                // If SKU is globally unique, we might need a workaround or not copy it. 
                // Let's assume for now we might need to nullify SKU or append patient ID if unique constraint fails.
                // Ideally, patient's med shouldn't be "inventory tracked" in the same way, but for now copying structure.
                'dosage' => $inventoryMed->dosage,
                'price' => $inventoryMed->price,
                'instructions' => $prescription->instructions ?? $inventoryMed->instructions,
                'total_stock' => $prescription->total_quantity, // Initial stock from prescription
                'current_stock' => $prescription->total_quantity,
                'threshold_alert' => 5,
                'color_code' => $inventoryMed->color_code,
                'image_path' => $inventoryMed->image_path
            ]);
        } else {
            // Top up existing medication
            $patientMed->increment('total_stock', $prescription->total_quantity);
            $patientMed->increment('current_stock', $prescription->total_quantity);
        }

        // B. Create Schedule Entries based on Frequency
        // Simple logic: mapping frequency to times
        $times = $this->getTimesFromFrequency($prescription->frequency);
        
        foreach ($times as $time) {
            // Check if schedule exists
            $exists = \App\Models\Schedule::where('medication_id', $patientMed->id)
                ->where('scheduled_time', $time)
                ->exists();
            
            if (!$exists) {
                \App\Models\Schedule::create([
                    'medication_id' => $patientMed->id,
                    'time_period' => $this->getTimePeriod($time),
                    'scheduled_time' => $time,
                    'days_of_week' => [1, 2, 3, 4, 5, 6, 7], // Every day
                    'is_active' => true
                ]);
            }
        }
    }

    private function getTimesFromFrequency($frequency)
    {
        // Simple mapping for demo purposes
        return match(strtolower($frequency)) {
            'qd', 'daily', '1 vez al dia' => ['09:00'],
            'bid', '2 veces al dia' => ['09:00', '21:00'],
            'tid', '3 veces al dia' => ['08:00', '14:00', '20:00'],
            'qid', '4 veces al dia' => ['08:00', '12:00', '16:00', '20:00'],
            default => ['09:00'] // Default to once daily
        };
    }

    private function getTimePeriod($time)
    {
        $hour = (int) substr($time, 0, 2);
        if ($hour < 12) return 'morning';
        if ($hour < 18) return 'afternoon';
        if ($hour < 21) return 'evening';
        return 'night';
    }

    /**
     * Display prescriptions for a patient.
     */
    /**
     * Display prescriptions history.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        // Admin and Doctor roles share the "Prescriber" view
        if ($user->role === 'doctor' || $user->role === 'admin') {
            // Doctors see prescriptions they issued
            $prescriptions = Prescription::where('doctor_id', $user->id)
                ->with(['patient', 'medication'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            // Patients see prescriptions they received
            $prescriptions = Prescription::where('patient_id', $user->id)
                ->with(['doctor', 'medication'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('prescriptions.index', compact('prescriptions'));
    }

    /**
     * Show prescription details.
     */
    /**
     * Display prescription details.
     */
    public function show(Prescription $prescription)
    {
        $prescription->load(['doctor', 'patient', 'medication']);
        
        return view('prescriptions.show', compact('prescription'));
    }

    /**
     * Download the prescription as PDF.
     */
    public function download(Prescription $prescription)
    {
        $prescription->load(['doctor', 'patient', 'medication']);
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('prescriptions.pdf', compact('prescription'));
        
        return $pdf->download('receta-' . $prescription->id . '.pdf');
    }
}
