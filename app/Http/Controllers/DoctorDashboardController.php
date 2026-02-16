<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Prescription;
use App\Models\Medication;
use App\Models\AdherenceLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DoctorDashboardController extends Controller
{
    /**
     * Doctor's Main Dashboard
     */
    public function index()
    {
        // Stats for the dashboard
        $totalPatients = User::where('role', 'patient')->count();
        $prescriptionsCount = Prescription::count();
        $criticalStock = Medication::where('current_stock', '<=', 5)->count(); // Threshold logic
        
        // Recent Prescriptions
        $recentPrescriptions = Prescription::with(['patient', 'medication'])
            ->latest()
            ->take(5)
            ->get();

        // Adherence Stats (Mock logic for now, or aggregate from logs)
        $adherenceRate = 85; // Placeholder or calculate dynamically
        
        return view('doctor.dashboard', compact('totalPatients', 'prescriptionsCount', 'criticalStock', 'recentPrescriptions', 'adherenceRate'));
    }

    /**
     * Patient Directory
     */
    public function patients()
    {
        $patients = User::where('role', 'patient')
            // Get patients with their latest prescription for "current diagnosis" context if available
            // In real app, diagnosis is on User model as per Phase 4
            ->with(['prescriptions.medication', 'adherenceLogs'])
            ->get()
            ->map(function ($patient) {
                // Calculate individual adherence
                $totalLogs = $patient->adherenceLogs()->count();
                $takenLogs = $patient->adherenceLogs()->where('status', 'taken')->count();
                $patient->adherence_score = $totalLogs > 0 ? round(($takenLogs / $totalLogs) * 100) : 0;
                return $patient;
            });

        return view('doctor.patients.index', compact('patients'));
    }

    /**
     * Pharmacy Inventory
     */
    public function inventory()
    {
        $medications = Medication::all();
        $totalValue = $medications->sum(function($med) {
             // Assuming a mock price since it's not in the migration yet, or 0
             return $med->current_stock * 0.50; 
        });
        $criticalCount = $medications->where('current_stock', '<=', 10)->count();
        
        return view('doctor.inventory.index', compact('medications', 'totalValue', 'criticalCount'));
    }

    /**
     * Add stock to medication.
     */
    public function addStock(Request $request, Medication $medication)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $medication->increment('current_stock', $request->quantity);

        return redirect()->back()->with('success', "Stock updated for {$medication->name}. Added {$request->quantity} units.");
    }
    /**
     * Show form to create new medication.
     */
    public function create()
    {
        return view('doctor.inventory.create');
    }

    /**
     * Store a newly created medication.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:medications,sku|max:50',
            'price' => 'required|numeric|min:0',
            'dosage' => 'required|string|max:100',
            'instructions' => 'nullable|string',
            'total_stock' => 'required|integer|min:0',
            'current_stock' => 'required|integer|min:0|lte:total_stock',
            'threshold_alert' => 'required|integer|min:0',
            'color_code' => 'sometimes|string|max:7',
        ]);

        // In a real app, assign to clinic or admin. Here using auth user (doctor/admin)
        // Ensure the ID is valid. If using a seeder, admin might be ID 1.
        $user = auth()->user(); 

        Medication::create([
            'user_id' => $user->id, // Assign ownership to the creator
            'name' => $request->name,
            'sku' => $request->sku,
            'price' => $request->price,
            'dosage' => $request->dosage,
            'instructions' => $request->instructions,
            'total_stock' => $request->total_stock,
            'current_stock' => $request->current_stock,
            'threshold_alert' => $request->threshold_alert,
            'color_code' => $request->color_code ?? '#3b82f6',
        ]);

        return redirect()->route('doctor.inventory')->with('success', 'Medicamento agregado al inventario correctamente.');
    }
}
