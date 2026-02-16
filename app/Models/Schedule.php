<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    protected $fillable = [
        'medication_id',
        'time_period',
        'scheduled_time',
        'days_of_week',
        'is_active'
    ];

    protected $casts = [
        'days_of_week' => 'array',
        'scheduled_time' => 'datetime:H:i',
        'is_active' => 'boolean'
    ];

    /**
     * Get the medication for the schedule.
     */
    public function medication(): BelongsTo
    {
        return $this->belongsTo(Medication::class);
    }

    /**
     * Get the adherence logs for the schedule.
     */
    public function adherenceLogs(): HasMany
    {
        return $this->hasMany(AdherenceLog::class);
    }

    /**
     * Check if this schedule is active for today.
     */
    public function isScheduledForToday(): bool
    {
        $today = now()->dayOfWeek; // 0=Sunday, 6=Saturday
        $todayMonBased = $today == 0 ? 7 : $today; // Convert to 1=Monday, 7=Sunday
        return in_array($todayMonBased, $this->days_of_week ?? []);
    }

    /**
     * Get the formatted time period label.
     */
    public function getTimePeriodLabelAttribute(): string
    {
        return ucfirst($this->time_period);
    }

    /**
     * Get the time range for this period.
     */
    public function getTimeRangeAttribute(): string
    {
        return match($this->time_period) {
            'morning' => '06:00 - 12:00',
            'afternoon' => '12:00 - 18:00',
            'evening' => '18:00 - 21:00',
            'night' => '21:00 - 06:00',
            default => ''
        };
    }
}
