<?php

namespace App\Services;

use App\Models\User;
use App\Models\Achievement;

class GamificationService
{
    /**
     * Check and award badges based on user performance.
     */
    public function checkAndAwardBadges(User $user, AdherenceCalculator $calculator): void
    {
        $weeklyScore = $calculator->calculateWeeklyScore($user);
        $streak = $calculator->calculateStreak($user);

        // Consistency Master: 7-day streak
        if ($streak >= 7 && !$this->hasAchievement($user, 'consistency_master')) {
            $this->awardBadge($user, 'consistency_master', 'Consistency Master', '7-day perfect streak achieved!');
        }

        // Target Hitter: Weekly score >= 90%
        if ($weeklyScore >= 90 && !$this->hasAchievement($user, 'target_hitter')) {
            $this->awardBadge($user, 'target_hitter', 'Target Hitter', 'Achieved 90%+ adherence for the week!');
        }

        // New Milestone: 30-day streak
        if ($streak >= 30 && !$this->hasAchievement($user, 'new_milestone')) {
            $this->awardBadge($user, 'new_milestone', 'New Milestone', '30-day perfect streak achieved!');
        }

        // Perfect Week: 7 days at 100%
        if ($weeklyScore == 100 && !$this->hasRecentAchievement($user, 'perfect_week')) {
            $this->awardBadge($user, 'perfect_week', 'Perfect Week', '100% adherence for 7 days!');
        }
    }

    /**
     * Award a badge to the user.
     */
    private function awardBadge(User $user, string $badgeType, string $title, string $description): void
    {
        Achievement::create([
            'user_id' => $user->id,
            'badge_type' => $badgeType,
            'title' => $title,
            'description' => $description,
            'earned_at' => now()
        ]);
    }

    /**
     * Check if user has a specific achievement.
     */
    private function hasAchievement(User $user, string $badgeType): bool
    {
        return $user->achievements()->where('badge_type', $badgeType)->exists();
    }

    /**
     * Check if user earned achievement recently (within last week).
     */
    private function hasRecentAchievement(User $user, string $badgeType): bool
    {
        return $user->achievements()
            ->where('badge_type', $badgeType)
            ->where('earned_at', '>=', now()->subWeek())
            ->exists();
    }
}
