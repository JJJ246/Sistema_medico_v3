<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdherenceLog extends Model
{
    protected $fillable = [
        'medication_id',
        'schedule_id',
        'log_date',
        'status',
        'taken_at',
        'snoozed_until'
    ];

    protected $casts = [
        'log_date' => 'date',
        'taken_at' => 'datetime',
        'snoozed_until' => 'datetime'
    ];

    /**
     * Get the medication for the log.
     */
    public function medication(): BelongsTo
    {
        return $this->belongsTo(Medication::class);
    }

    /**
     * Get the schedule for the log.
     */
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Check if medication was taken.
     */
    public function isTaken(): bool
    {
        return $this->status === 'taken';
    }

    /**
     * Check if medication is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if medication was missed.
     */
    public function isMissed(): bool
    {
        return $this->status === 'missed';
    }

    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'taken' => 'green',
            'pending' => 'orange',
            'missed' => 'red',
            'snoozed' => 'blue',
            default => 'gray'
        };
    }
}
