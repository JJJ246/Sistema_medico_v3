<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Doctor extends Model
{
    protected $fillable = [
        'name',
        'specialty',
        'photo_path',
        'email',
        'phone'
    ];

    /**
     * Get the medications prescribed by this doctor.
     */
    public function medications(): BelongsToMany
    {
        return $this->belongsToMany(Medication::class)
            ->withPivot('prescribed_at')
            ->withTimestamps();
    }

    /**
     * Get the full name attribute (alias for name).
     */
    public function getFullNameAttribute(): string
    {
        return $this->name;
    }
}
