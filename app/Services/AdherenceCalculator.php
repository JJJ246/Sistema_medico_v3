<?php

namespace App\Services;

use App\Models\User;
use App\Models\AdherenceLog;
use App\Models\Schedule;
use Carbon\Carbon;

class AdherenceCalculator
{
    /**
     * Calculate weekly adherence score (0-100%).
     */
    public function calculateWeeklyScore(User $user): int
    {
        $startDate = now()->subDays(6)->startOfDay();
        $endDate = now()->endOfDay();

        // Get all schedules for user's medications
        $schedules = Schedule::whereHas('medication', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('is_active', true)->get();

        $totalScheduled = 0;
        $totalTaken = 0;

        // Count for each day in the past 7 days
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            foreach ($schedules as $schedule) {
                if ($schedule->isScheduledForToday()) {
                    $totalScheduled++;
                    
                    $log = AdherenceLog::where('schedule_id', $schedule->id)
                        ->where('log_date', $date->toDateString())
                        ->where('status', 'taken')
                        ->first();
                    
                    if ($log) {
                        $totalTaken++;
                    }
                }
            }
        }

        if ($totalScheduled == 0) {
            return 0;
        }

        return (int) round(($totalTaken / $totalScheduled) * 100);
    }

    /**
     * Calculate current streak (consecutive days at 100% adherence).
     */
    public function calculateStreak(User $user): int
    {
        $streak = 0;
        $date = now()->subDay(); // Start from yesterday

        while (true) {
            $dayScore = $this->calculateDayScore($user, $date);
            
            if ($dayScore < 100) {
                break;
            }
            
            $streak++;
            $date->subDay();
            
            // Limit to reasonable time frame (e.g., 365 days max)
            if ($streak >= 365) {
                break;
            }
        }

        return $streak;
    }

    /**
     * Calculate adherence score for a specific day.
     */
    public function calculateDayScore(User $user, Carbon $date): int
    {
        $schedules = Schedule::whereHas('medication', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('is_active', true)->get();

        $totalScheduled = 0;
        $totalTaken = 0;

        foreach ($schedules as $schedule) {
            // Check if this schedule applies to this day of week
            $dayOfWeek = $date->dayOfWeek == 0 ? 7 : $date->dayOfWeek;
            if (!in_array($dayOfWeek, $schedule->days_of_week ?? [])) {
                continue;
            }

            $totalScheduled++;
            
            $log = AdherenceLog::where('schedule_id', $schedule->id)
                ->where('log_date', $date->toDateString())
                ->where('status', 'taken')
                ->first();
            
            if ($log) {
                $totalTaken++;
            }
        }

        if ($totalScheduled == 0) {
            return 100; // No medications scheduled = perfect day
        }

        return (int) round(($totalTaken / $totalScheduled) * 100);
    }

    /**
     * Check and mark missed medications (run via CRON).
     */
    public function checkMissedMedications(): void
    {
        $now = now();
        
        $missedLogs = AdherenceLog::where('status', 'pending')
            ->whereHas('schedule', function ($query) use ($now) {
                $query->where('scheduled_time', '<', $now->format('H:i:s'));
            })
            ->where('log_date', '<', $now->toDateString())
            ->get();

        foreach ($missedLogs as $log) {
            $log->update(['status' => 'missed']);
        }
    }
}
