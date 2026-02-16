<?php

namespace App\Http\Controllers;

use App\Services\AdherenceCalculator;
use App\Services\StockManager;
use App\Models\Schedule;
use App\Models\AdherenceLog;
use Illuminate\Http\Request;

class AdherenceController extends Controller
{
    public function __construct(
        protected AdherenceCalculator $calculator,
        protected StockManager $stockManager
    ) {}

    /**
     * Mark medication as taken.
     */
    public function markAsTaken(Request $request, Schedule $schedule)
    {
        try {
            // Create or update adherence log
            $log = AdherenceLog::updateOrCreate(
                [
                    'medication_id' => $schedule->medication_id,
                    'schedule_id' => $schedule->id,
                    'log_date' => now()->toDateString()
                ],
                [
                    'status' => 'taken',
                    'taken_at' => now()
                ]
            );

            // Deduct stock only if it wasn't already taken today to avoid double deduction
            if ($log->wasRecentlyCreated) {
                $this->stockManager->deductOnTaken($schedule->medication);
            }

            return redirect()->back()->with('success', 'Medicamento marcado como tomado. Stock actualizado.');
        } catch (\Exception $e) {
            // Handle unique constraint violation gracefully
            return redirect()->back()->with('info', 'Este medicamento ya fue marcado como tomado hoy.');
        }
    }

    /**
     * Snooze medication reminder.
     */
    public function snooze(Request $request, Schedule $schedule)
    {
        $minutes = $request->input('minutes', 10);
        
        $log = AdherenceLog::updateOrCreate(
            [
                'medication_id' => $schedule->medication_id,
                'schedule_id' => $schedule->id,
                'log_date' => now()->toDateString()
            ],
            [
                'status' => 'snoozed',
                'snoozed_until' => now()->addMinutes($minutes)
            ]
        );

        return redirect()->back()->with('info', "Reminder snoozed for {$minutes} minutes.");
    }

    /**
     * Get weekly score (AJAX).
     */
    public function getWeeklyScore()
    {
        $score = $this->calculator->calculateWeeklyScore(auth()->user());
        return response()->json(['score' => $score]);
    }

    /**
     * Get current streak (AJAX).
     */
    public function getStreak()
    {
        $streak = $this->calculator->calculateStreak(auth()->user());
        return response()->json(['streak' => $streak]);
    }
}
