<?php

namespace App\Services;

use App\Models\Medication;
use App\Models\User;
use Illuminate\Support\Collection;

class StockManager
{
    /**
     * Deduct stock when medication is taken.
     */
    public function deductOnTaken(Medication $medication): void
    {
        $medication->deductStock();
    }

    /**
     * Get medications with low stock (< 5 pills).
     */
    public function checkLowStockAlerts(User $user): Collection
    {
        return $user->medications()
            ->where('current_stock', '<', 5)
            ->get();
    }

    /**
     * Check if medication needs refill.
     */
    public function needsRefill(Medication $medication): bool
    {
        return $medication->isLowStock();
    }

    /**
     * Add stock (for refills).
     */
    public function addStock(Medication $medication, int $quantity): void
    {
        $medication->increment('current_stock', $quantity);
        
        // Also update total_stock if needed
        if ($medication->current_stock > $medication->total_stock) {
           $medication->update(['total_stock' => $medication->current_stock]);
        }
    }
}
