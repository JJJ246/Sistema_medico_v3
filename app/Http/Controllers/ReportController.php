<?php

namespace App\Http\Controllers;

use App\Services\AdherenceCalculator;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(
        protected AdherenceCalculator $calculator
    ) {}

    /**
     * Display adherence analytics and gamification.
     */
    public function index()
    {
        $user = auth()->user();
        
        // Calculate metrics
        $weeklyScore = $this->calculator->calculateWeeklyScore($user);
        $streak = $this->calculator->calculateStreak($user);
        
        // Get daily adherence for past week
        $dailyAdherence = [];
        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $score = $this->calculator->calculateDayScore($user, $date);
            $dailyAdherence[] = [
                'day' => $days[$date->dayOfWeek == 0 ? 6 : $date->dayOfWeek - 1],
                'score' => $score
            ];
        }

        // Get achievements
        $achievements = $user->achievements()
            ->orderBy('earned_at', 'desc')
            ->take(3)
            ->get();

        return view('reports.index', compact('weeklyScore', 'streak', 'dailyAdherence', 'achievements'));
    }

    /**
     * Download PDF summary.
     */
    public function downloadPDF()
    {
        // TODO: Implement PDF generation with DomPDF or similar
        return redirect()->back()->with('info', 'PDF download will be available soon.');
    }
}
