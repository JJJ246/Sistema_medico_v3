<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prescription extends Model
{
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'medication_id',
        'frequency',
        'duration_days',
        'total_quantity',
        'instructions',
        'issued_at'
    ];

    protected $casts = [
        'issued_at' => 'datetime'
    ];

    /**
     * Boot method to auto-calculate total_quantity.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($prescription) {
            $prescription->calculateTotalQuantity();
        });
    }

    /**
     * Calculate total quantity based on frequency and duration.
     */
    public function calculateTotalQuantity(): void
    {
        $dailyDoses = $this->parseDailyDoses($this->frequency);
        $this->total_quantity = $dailyDoses * $this->duration_days;
    }

    /**
     * Parse frequency string to get daily doses.
     */
    private function parseDailyDoses(string $frequency): int
    {
        // q8h = every 8 hours = 24/8 = 3 doses/day
        if (preg_match('/q(\d+)h/', $frequency, $matches)) {
            return (int) (24 / $matches[1]);
        }
        
        // Medical abbreviations
        $frequencyMap = [
            'daily' => 1,
            'qd' => 1,     // Once daily
            'bid' => 2,    // Twice daily
            'tid' => 3,    // Three times daily
            'qid' => 4,    // Four times daily
        ];
        
        return $frequencyMap[strtolower($frequency)] ?? 1;
    }

    /**
     * Relationships
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function medication(): BelongsTo
    {
        return $this->belongsTo(Medication::class);
    }
}
