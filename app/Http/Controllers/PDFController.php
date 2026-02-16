<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\AdherenceCalculator;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    protected $calculator;

    public function __construct(AdherenceCalculator $calculator)
    {
        $this->calculator = $calculator;
    }

    /**
     * Download health summary PDF report.
     */
    public function downloadHealthSummary(Request $request)
    {
        $userId = $request->input('user_id', auth()->id());
        $user = User::with(['medications', 'achievements'])->findOrFail($userId);
        
        $data = [
            'patient' => $user,
            'weeklyScore' => $this->calculator->calculateWeeklyScore($user),
            'streak' => $this->calculator->calculateStreak($user),
            'medications' => $user->medications()->with('schedules')->get(),
            'achievements' => $user->achievements()->orderBy('earned_at', 'desc')->get(),
            'generatedAt' => now()->format('F d, Y H:i'),
        ];
        
        $pdf = Pdf::loadView('pdf.health-summary', $data);
        
        $filename = 'health-summary-' . ($user->mrn ?? 'user-' . $user->id) . '-' . now()->format('Ymd') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Preview health summary PDF in browser.
     */
    public function previewHealthSummary(Request $request)
    {
        $userId = $request->input('user_id', auth()->id());
        $user = User::with(['medications', 'achievements'])->findOrFail($userId);
        
        $data = [
            'patient' => $user,
            'weeklyScore' => $this->calculator->calculateWeeklyScore($user),
            'streak' => $this->calculator->calculateStreak($user),
            'medications' => $user->medications()->with('schedules')->get(),
            'achievements' => $user->achievements()->orderBy('earned_at', 'desc')->get(),
            'generatedAt' => now()->format('F d, Y H:i'),
        ];
        
        $pdf = Pdf::loadView('pdf.health-summary', $data);
        
        return $pdf->stream();
    }
}
