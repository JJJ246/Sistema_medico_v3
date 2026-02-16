<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\AdherenceLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display interactive medication schedule.
     */
    public function index(Request $request)
    {
        $date = $request->input('date') ? Carbon::parse($request->input('date')) : now();
        
        // Get week dates (7 days centered on selected date)
        $weekDates = collect();
        for ($i = -3; $i <= 3; $i++) {
            $weekDates->push($date->copy()->addDays($i));
        }

        // Get all active schedules for user's medications
        $user = auth()->user();
        $schedules = Schedule::whereHas('medication', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('is_active', true)
        ->with(['medication', 'adherenceLogs' => function ($query) use ($date) {
            $query->where('log_date', $date->toDateString());
        }])
        ->get();

        // Group by time period
        $schedulesByPeriod = [
            'morning' => $schedules->where('time_period', 'morning'),
            'afternoon' => $schedules->where('time_period', 'afternoon'),
            'evening' => $schedules->where('time_period', 'evening'),
            'night' => $schedules->where('time_period', 'night'),
        ];

        return view('schedule.index', compact('weekDates', 'date', 'schedulesByPeriod'));
    }
}
