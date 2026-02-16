<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medication;
use App\Models\Schedule;
use App\Models\AdherenceLog;
use Carbon\Carbon;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $medications = Medication::all();

        if ($medications->isEmpty()) {
            echo "No medications found. Run MedicationSeeder first.\n";
            return;
        }

        // Define schedules for different medications
        $scheduleData = [
            // Amoxicillin - 3 times a day
            ['medication_index' => 0, 'time_period' => 'morning', 'time' => '08:00:00', 'days' => [1,2,3,4,5,6,7]],
            ['medication_index' => 0, 'time_period' => 'afternoon', 'time' => '14:00:00', 'days' => [1,2,3,4,5,6,7]],
            ['medication_index' => 0, 'time_period' => 'night', 'time' => '22:00:00', 'days' => [1,2,3,4,5,6,7]],
            
            // Lisinopril - morning only
            ['medication_index' => 1, 'time_period' => 'morning', 'time' => '07:00:00', 'days' => [1,2,3,4,5,6,7]],
            
            // Metformin - twice a day
            ['medication_index' => 2, 'time_period' => 'morning', 'time' => '08:30:00', 'days' => [1,2,3,4,5,6,7]],
            ['medication_index' => 2, 'time_period' => 'evening', 'time' => '19:00:00', 'days' => [1,2,3,4,5,6,7]],
            
            // Aspirin - morning
            ['medication_index' => 3, 'time_period' => 'morning', 'time' => '09:00:00', 'days' => [1,2,3,4,5,6,7]],
            
            // Vitamin D - morning
            ['medication_index' => 4, 'time_period' => 'morning', 'time' => '08:00:00', 'days' => [1,2,3,4,5,6,7]],
        ];

        foreach ($scheduleData as $data) {
            if (!isset($medications[$data['medication_index']])) {
                continue;
            }

            $schedule = Schedule::create([
                'medication_id' => $medications[$data['medication_index']]->id,
                'time_period' => $data['time_period'],
                'scheduled_time' => $data['time'],
                'days_of_week' => $data['days'],
                'is_active' => true
            ]);

            // Create adherence logs for past 7 days with realistic data
            for ($i = 0; $i < 7; $i++) {
                $date = Carbon::now()->subDays($i)->toDateString();
                $randomStatus = $i === 0 ? 'pending' : (rand(1, 100) > 10 ? 'taken' : 'missed');
                
                AdherenceLog::create([
                    'medication_id' => $schedule->medication_id,
                    'schedule_id' => $schedule->id,
                    'log_date' => $date,
                    'status' => $randomStatus,
                    'taken_at' => $randomStatus === 'taken' ? Carbon::parse($date)->setTimeFromTimeString($data['time'])->addMinutes(rand(-30, 30)) : null
                ]);
            }
        }
    }
}
