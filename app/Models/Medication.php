<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Medication extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'dosage',
        'sku',
        'price',
        'instructions',
        'total_stock',
        'current_stock',
        'threshold_alert',
        'image_path',
        'color_code'
    ];

    /**
     * Get the user that owns the medication.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the schedules for the medication.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Get the adherence logs for the medication.
     */
    public function adherenceLogs(): HasMany
    {
        return $this->hasMany(AdherenceLog::class);
    }

    /**
     * Get the doctors that prescribed this medication.
     */
    public function doctors(): BelongsToMany
    {
        return $this->belongsToMany(Doctor::class)
            ->withPivot('prescribed_at')
            ->withTimestamps();
    }

    /**
     * Check if medication stock is critically low (≤ 3).
     */
    public function isCriticalStock(): bool
    {
        return $this->current_stock <= 3;
    }

    /**
     * Check if medication stock is below threshold.
     */
    public function isLowStock(): bool
    {
        return $this->current_stock < $this->threshold_alert;
    }

    /**
     * Deduct stock (single unit or specific quantity).
     */
    public function deductStock(int $quantity = 1): void
    {
        if ($this->current_stock >= $quantity) {
            $this->decrement('current_stock', $quantity);
        }
    }

    /**
     * Calculate stock percentage.
     */
    public function getStockPercentageAttribute(): float
    {
        if ($this->total_stock == 0) {
            return 0;
        }
        return ($this->current_stock / $this->total_stock) * 100;
    }
}
