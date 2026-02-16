<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\AdherenceController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\RegisterStepOneController;
use App\Http\Controllers\Auth\RegisterStepTwoController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\DoctorDashboardController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', [PageController::class, 'index'])->name('home');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Medications
    Route::resource('medications', MedicationController::class);
    Route::post('medications/{medication}/refill', [MedicationController::class, 'requestRefill'])->name('medications.refill');
    
    // Adherence Tracking
    Route::post('adherence/mark-taken/{schedule}', [AdherenceController::class, 'markAsTaken'])->name('adherence.taken');
    Route::post('adherence/snooze/{schedule}', [AdherenceController::class, 'snooze'])->name('adherence.snooze');
    Route::get('adherence/weekly-score', [AdherenceController::class, 'getWeeklyScore']);
    Route::get('adherence/streak', [AdherenceController::class, 'getStreak']);
    
    // Schedule
    Route::get('schedule', [ScheduleController::class, 'index'])->name('schedule.index');
    
    // Doctors
    Route::get('doctors', [DoctorController::class, 'index'])->name('doctors.index');
    Route::get('doctors/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');
    
    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/download-pdf', [ReportController::class, 'downloadPDF'])->name('reports.pdf');
    
    // Phase 4: Prescriptions
    Route::get('prescriptions/create', [PrescriptionController::class, 'create'])->name('prescriptions.create');
    Route::post('prescriptions', [PrescriptionController::class, 'store'])->name('prescriptions.store');
    Route::get('prescriptions', [PrescriptionController::class, 'index'])->name('prescriptions.index');
    Route::get('prescriptions/{prescription}', [PrescriptionController::class, 'show'])->name('prescriptions.show');
    Route::get('prescriptions/{prescription}/download', [PrescriptionController::class, 'download'])->name('prescriptions.download'); // PDF Download Route
    
    // Phase 4: Analytics API
    Route::get('api/analytics/adherence-chart', [AnalyticsController::class, 'getAdherenceChartData'])->name('api.analytics.chart');
    Route::get('api/analytics/weekly-summary', [AnalyticsController::class, 'getWeeklySummary'])->name('api.analytics.summary');
    
    // Phase 4: PDF Health Summary
    Route::get('health-summary/download', [PDFController::class, 'downloadHealthSummary'])->name('health.pdf.download');
    Route::get('health-summary/preview', [PDFController::class, 'previewHealthSummary'])->name('health.pdf.preview');
    
    // Phase 5: UI/UX Implementation (Doctor Portal)
    Route::get('/doctor/dashboard', [DoctorDashboardController::class, 'index'])->name('doctor.dashboard');
    Route::get('/doctor/patients', [DoctorDashboardController::class, 'patients'])->name('doctor.patients');
    Route::get('/doctor/inventory', [DoctorDashboardController::class, 'inventory'])->name('doctor.inventory');
    Route::get('/doctor/inventory/create', [DoctorDashboardController::class, 'create'])->name('doctor.inventory.create'); // New route
    Route::post('/doctor/inventory', [DoctorDashboardController::class, 'store'])->name('doctor.inventory.store'); // New route
    Route::post('/doctor/inventory/{medication}/add', [DoctorDashboardController::class, 'addStock'])->name('doctor.inventory.add');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
