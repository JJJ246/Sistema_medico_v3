<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\AdherenceLog;
use App\Services\AdherenceCalculator;
use App\Services\StockManager;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct(
        protected AdherenceCalculator $calculator,
        protected StockManager $stockManager
    ) {}

    /**
     * Display patient dashboard.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'doctor' || $user->role === 'admin') {
            return redirect()->route('doctor.dashboard');
        }
        
        // Get next scheduled medication (action required)
        $nextMedication = $this->getNextScheduledMedication();
        
        // Calculate adherence metrics
        $weeklyScore = $this->calculator->calculateWeeklyScore($user);
        $streak = $this->calculator->calculateStreak($user);
        
        // Get upcoming medications for today
        $upcomingMedications = $this->getUpcomingMedications();
        
        // Low stock alerts
        $lowStockMeds = $this->stockManager->checkLowStockAlerts($user);

        return view('dashboard', compact(
            'nextMedication',
            'weeklyScore',
            'streak',
            'upcomingMedications',
            'lowStockMeds'
        ));
    }

    /**
     * Get the next pending medication.
     */
    private function getNextScheduledMedication()
    {
        $now = now();
        $user = auth()->user();

        return Schedule::whereHas('medication', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('is_active', true)
        ->whereDoesntHave('adherenceLogs', function ($query) use ($now) {
            $query->where('log_date', $now->toDateString())
                  ->where('status', 'taken');
        })
        ->with('medication')
        ->orderBy('scheduled_time')
        ->first();
    }

    /**
     * Get upcoming medications for today.
     */
    private function getUpcomingMedications()
    {
        $now = now();
        $user = auth()->user();

        return Schedule::whereHas('medication', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('is_active', true)
        ->with(['medication', 'adherenceLogs' => function ($query) use ($now) {
            $query->where('log_date', $now->toDateString());
        }])
        ->orderBy('scheduled_time')
        ->take(4)
        ->get();
    }
}
