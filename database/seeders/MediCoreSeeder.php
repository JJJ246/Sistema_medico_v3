<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Medication;
use App\Models\Prescription;
use App\Models\Schedule;
use App\Models\AdherenceLog;
use App\Models\Achievement;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class MediCoreSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Doctor (Admin)
        $doctor = User::create([
            'name' => 'Dr. Alejandro Vargas',
            'full_name' => 'Dr. Alejandro Vargas',
            'email' => 'admin@medicore.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'profile_photo_path' => '/storage/profiles/dr_vargas.png',
            'birthdate' => '1980-05-15',
        ]);

        // 2. Create Patient 1: James Anderson
        $james = User::create([
            'name' => 'James Anderson',
            'full_name' => 'James Anderson',
            'email' => 'james@patient.com',
            'password' => Hash::make('patient123'),
            'role' => 'patient',
            'mrn' => '#882103',
            'diagnosis' => 'Metaplasia Escamosa',
            'profile_photo_path' => '/storage/profiles/james_anderson.png',
            'birthdate' => '1975-03-20',
        ]);

        // 3. Create Patient 2: Maria Gonzalez (100% adherence + 14-day streak)
        $maria = User::create([
            'name' => 'Maria Gonzalez',
            'full_name' => 'Maria Gonzalez',
            'email' => 'maria@patient.com',
            'password' => Hash::make('patient123'),
            'role' => 'patient',
            'mrn' => '#994421',
            'diagnosis' => 'Displasia de Grado I',
            'profile_photo_path' => '/storage/profiles/maria_gonzalez.jpg',
            'birthdate' => '1988-07-12',
        ]);

        // 4. Create Medications with exact inventory
        
        // For Maria
        $amoxicillin = Medication::create([
            'user_id' => $maria->id,
            'name' => 'Amoxicillin',
            'dosage' => '500mg',
            'sku' => 'AMX-500',
            'price' => 12.50,
            'current_stock' => 12, // LOW STOCK ALERT
            'total_stock' => 100,
            'threshold_alert' => 15,
            'instructions' => 'Take with water after meals',
            'color_code' => '#3b82f6',
        ]);

        $metformin = Medication::create([
            'user_id' => $maria->id,
            'name' => 'Metformin',
            'dosage' => '850mg',
            'sku' => 'MET-850',
            'price' => 8.75,
            'current_stock' => 250,
            'total_stock' => 500,
            'threshold_alert' => 50,
            'instructions' => 'Take with meals, twice daily',
            'color_code' => '#10b981',
        ]);

        // For James
        $lisinopril = Medication::create([
            'user_id' => $james->id,
            'name' => 'Lisinopril',
            'dosage' => '10mg',
            'sku' => 'LIS-020',
            'price' => 15.00,
            'current_stock' => 2, // CRITICAL STOCK
            'total_stock' => 100,
            'threshold_alert' => 10,
            'instructions' => 'Take in the morning',
            'color_code' => '#ef4444',
        ]);

        // 5. Create Prescriptions
        $prescriptionAmox = Prescription::create([
            'doctor_id' => $doctor->id,
            'patient_id' => $maria->id,
            'medication_id' => $amoxicillin->id,
            'frequency' => 'q8h', // Every 8 hours = 3 doses/day
            'duration_days' => 10,
            'instructions' => 'Complete full course even if symptoms improve',
            'issued_at' => now()->subDays(4),
        ]);

        $prescriptionMet = Prescription::create([
            'doctor_id' => $doctor->id,
            'patient_id' => $maria->id,
            'medication_id' => $metformin->id,
            'frequency' => 'bid', // Twice daily
            'duration_days' => 30,
            'instructions' => 'Take with breakfast and dinner',
            'issued_at' => now()->subDays(15),
        ]);

        $prescriptionLis = Prescription::create([
            'doctor_id' => $doctor->id,
            'patient_id' => $james->id,
            'medication_id' => $lisinopril->id,
            'frequency' => 'daily', // Once daily
            'duration_days' => 30,
            'instructions' => 'Monitor blood pressure regularly',
            'issued_at' => now()->subDays(22),
        ]);

        // 6. Create Schedules for Maria (for 14-day streak)
        $amoxSchedules = [
            Schedule::create([
                'medication_id' => $amoxicillin->id,
                'time_period' => 'morning',
                'scheduled_time' => '08:00:00',
                'days_of_week' => [1,2,3,4,5,6,7],
                'is_active' => true,
            ]),
            Schedule::create([
                'medication_id' => $amoxicillin->id,
                'time_period' => 'afternoon',
                'scheduled_time' => '16:00:00',
                'days_of_week' => [1,2,3,4,5,6,7],
                'is_active' => true,
            ]),
            Schedule::create([
                'medication_id' => $amoxicillin->id,
                'time_period' => 'night',
                'scheduled_time' => '00:00:00',
                'days_of_week' => [1,2,3,4,5,6,7],
                'is_active' => true,
            ]),
        ];

        $metSchedules = [
            Schedule::create([
                'medication_id' => $metformin->id,
                'time_period' => 'morning',
                'scheduled_time' => '08:30:00',
                'days_of_week' => [1,2,3,4,5,6,7],
                'is_active' => true,
            ]),
            Schedule::create([
                'medication_id' => $metformin->id,
                'time_period' => 'evening',
                'scheduled_time' => '19:00:00',
                'days_of_week' => [1,2,3,4,5,6,7],
                'is_active' => true,
            ]),
        ];

        // 7. Create 14 days of PERFECT adherence logs for Maria (100% + 14 Day Streak)
        for ($i = 0; $i < 14; $i++) {
            $date = now()->subDays($i);
            
            // Amoxicillin (3 times daily - all taken)
            foreach ($amoxSchedules as $index => $schedule) {
                AdherenceLog::updateOrCreate(
                    [
                        'medication_id' => $amoxicillin->id,
                        'schedule_id' => $schedule->id,
                        'log_date' => $date->toDateString(),
                    ],
                    [
                        'status' => 'taken',
                        'taken_at' => $date->copy()->setTimeFromTimeString($schedule->scheduled_time)->addMinutes(rand(-15, 30)),
                    ]
                );
            }
            
            // Metformin (2 times daily - all taken)
            foreach ($metSchedules as $schedule) {
                AdherenceLog::updateOrCreate(
                    [
                        'medication_id' => $metformin->id,
                        'schedule_id' => $schedule->id,
                        'log_date' => $date->toDateString(),
                    ],
                    [
                        'status' => 'taken',
                        'taken_at' => $date->copy()->setTimeFromTimeString($schedule->scheduled_time)->addMinutes(rand(-10, 20)),
                    ]
                );
            }
        }

        // 9. Award achievements to Maria for 14-day streak
        Achievement::create([
            'user_id' => $maria->id,
            'badge_type' => 'consistency_master',
            'title' => 'Consistency Master',
            'description' => '7-day perfect adherence streak',
            'earned_at' => now()->subDays(7),
        ]);

        Achievement::create([
            'user_id' => $maria->id,
            'badge_type' => 'new_milestone',
            'title' => 'New Milestone',
            'description' => '14-day perfect adherence streak',
            'earned_at' => now(),
        ]);

        Achievement::create([
            'user_id' => $maria->id,
            'badge_type' => 'target_hitter',
            'title' => 'Target Hitter',
            'description' => '100% weekly adherence achieved',
            'earned_at' => now()->subDays(2),
        ]);

        echo "\n✅ MediCore seeder completed successfully!\n";
        echo "📊 Created:\n";
        echo "   - 1 Doctor (admin@medicore.com / admin123)\n";
        echo "   - 2 Patients (maria@patient.com & james@patient.com / patient123)\n";
        echo "   - 3 Medications (Amoxicillin: 12 stock LOW, Metformin: 250 stock, Lisinopril: 2 stock CRITICAL)\n";
        echo "   - 3 Prescriptions\n";
        echo "   - Maria: 100% adherence + 14 Day Streak 🔥\n";
        echo "   - 3 Achievements for Maria\n\n";
    }
}
