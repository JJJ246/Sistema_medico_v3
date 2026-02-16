<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AdherenceLog;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    /**
     * Get adherence chart data for last 7 days.
     * Returns JSON with daily taken vs missed counts.
     */
    public function getAdherenceChartData(Request $request)
    {
        $userId = $request->input('user_id', auth()->id());
        $user = User::findOrFail($userId);
        
        $chartData = [];
        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dayIndex = $date->dayOfWeek == 0 ? 6 : $date->dayOfWeek - 1; // Convert to Mon=0
            
            // Count taken medications
            $taken = AdherenceLog::whereHas('medication', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->where('log_date', $date->toDateString())
            ->where('status', 'taken')
            ->count();
            
            // Count missed medications
            $missed = AdherenceLog::whereHas('medication', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->where('log_date', $date->toDateString())
            ->where('status', 'missed')
            ->count();
            
            $chartData[] = [
                'day' => $days[$dayIndex],
                'date' => $date->format('Y-m-d'),
                'taken' => $taken,
                'missed' => $missed,
                'total' => $taken + $missed,
            ];
        }
        
        return response()->json($chartData);
    }

    /**
     * Get weekly adherence summary.
     */
    public function getWeeklySummary(Request $request)
    {
        $userId = $request->input('user_id', auth()->id());
        $user = User::findOrFail($userId);
        
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $totalTaken = AdherenceLog::whereHas('medication', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
        ->whereBetween('log_date', [$startDate, $endDate])
        ->where('status', 'taken')
        ->count();

        $totalScheduled = AdherenceLog::whereHas('medication', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
        ->whereBetween('log_date', [$startDate, $endDate])
        ->count();

        $adherenceScore = $totalScheduled > 0 ? round(($totalTaken / $totalScheduled) * 100) : 0;

        return response()->json([
            'score' => $adherenceScore,
            'taken' => $totalTaken,
            'total' => $totalScheduled,
        ]);
    }
}
