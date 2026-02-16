<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Achievement extends Model
{
    protected $fillable = [
        'user_id',
        'badge_type',
        'title',
        'description',
        'earned_at'
    ];

    protected $casts = [
        'earned_at' => 'datetime'
    ];

    /**
     * Get the user that earned the achievement.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the badge icon based on type.
     */
    public function getBadgeIconAttribute(): string
    {
        return match($this->badge_type) {
            'consistency_master' => '🥇',
            'target_hitter' => '🥈',
            'new_milestone' => '🥉',
            'perfect_week' => '⭐',
            default => '🏆'
        };
    }
}
