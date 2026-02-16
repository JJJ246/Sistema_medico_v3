<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use App\Services\StockManager;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    public function __construct(
        protected StockManager $stockManager
    ) {}

    /**
     * Display medication inventory.
     */
    public function index()
    {
        $medications = auth()->user()->medications()->with('schedules')->get();
        $lowStockMeds = $this->stockManager->checkLowStockAlerts(auth()->user());
        
        return view('medications.index', compact('medications', 'lowStockMeds'));
    }

    /**
     * Store new medication.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'dosage' => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'total_stock' => 'required|integer|min:1',
            'current_stock' => 'required|integer|min:0',
            'image_path' => 'nullable|string',
            'color_code' => 'nullable|string'
        ]);

        $validated['user_id'] = auth()->id();
        Medication::create($validated);

        return redirect()->route('medications.index')->with('success', 'Medication added successfully!');
    }

    /**
     * Update medication.
     */
    public function update(Request $request, Medication $medication)
    {
        $this->authorize('update', $medication);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'dosage' => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'total_stock' => 'required|integer|min:1',
            'current_stock' => 'required|integer|min:0',
        ]);

        $medication->update($validated);

        return redirect()->route('medications.index')->with('success', 'Medication updated successfully!');
    }

    /**
     * Delete medication.
     */
    public function destroy(Medication $medication)
    {
        $this->authorize('delete', $medication);
        
        $medication->delete();

        return redirect()->route('medications.index')->with('success', 'Medication deleted successfully!');
    }

    /**
     * Request refill for low stock medication.
     */
    public function requestRefill(Medication $medication)
    {
        $this->authorize('update', $medication);

        // TODO: Implement actual refill request logic (notify doctor, pharmacy, etc.)
        
        return redirect()->back()->with('success', 'Refill request sent for ' . $medication->name . '!');
    }
}
