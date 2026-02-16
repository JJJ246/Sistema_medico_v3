<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Medication;
use App\Models\Doctor;

class MedicationSeeder extends Seeder
{
    public function run(): void
    {
        // Get first user (you should have one registered)
        $user = User::first();
        
        if (!$user) {
            echo "No user found. Please register a user first.\n";
            return;
        }

        $medications = [
            [
                'name' => 'Amoxicillin',
                'sku' => 'MED-001',
                'price' => 12.50,
                'dosage' => '500mg',
                'instructions' => 'Take with water after meals',
                'total_stock' => 30,
                'current_stock' => 22,
                'threshold_alert' => 10,
                'color_code' => '#3b82f6'
            ],
            [
                'name' => 'Lisinopril',
                'sku' => 'MED-002',
                'price' => 15.00,
                'dosage' => '10mg',
                'instructions' => 'Take in the morning',
                'total_stock' => 30,
                'current_stock' => 2, // Low stock
                'threshold_alert' => 5,
                'color_code' => '#ef4444'
            ],
            [
                'name' => 'Metformin',
                'sku' => 'MED-003',
                'price' => 8.75,
                'dosage' => '850mg',
                'instructions' => 'Take with meals',
                'total_stock' => 60,
                'current_stock' => 45,
                'threshold_alert' => 15,
                'color_code' => '#10b981'
            ],
            [
                'name' => 'Aspirin',
                'sku' => 'MED-004',
                'price' => 5.00,
                'dosage' => '100mg',
                'instructions' => 'Take with water',
                'total_stock' => 30,
                'current_stock' => 18,
                'threshold_alert' => 10,
                'color_code' => '#f59e0b'
            ],
            [
                'name' => 'Vitamin D',
                'sku' => 'MED-005',
                'price' => 10.00,
                'dosage' => '1000 IU',
                'instructions' => 'Take with breakfast',
                'total_stock' => 60,
                'current_stock' => 38,
                'threshold_alert' => 10,
                'color_code' => '#fbbf24'
            ],
            [
                'name' => 'Ibuprofen',
                'sku' => 'MED-006',
                'price' => 6.50,
                'dosage' => '400mg',
                'instructions' => 'Take as needed for pain',
                'total_stock' => 20,
                'current_stock' => 12,
                'threshold_alert' => 5,
                'color_code' => '#8b5cf6'
            ],
        ];

        foreach ($medications as $medData) {
            $medication = Medication::create([
                'user_id' => $user->id,
                'name' => $medData['name'],
                'sku' => $medData['sku'],
                'price' => $medData['price'],
                'dosage' => $medData['dosage'],
                'instructions' => $medData['instructions'],
                'total_stock' => $medData['total_stock'],
                'current_stock' => $medData['current_stock'],
                'threshold_alert' => $medData['threshold_alert'],
                'color_code' => $medData['color_code']
            ]);

            // Link to doctors
            $doctors = Doctor::inRandomOrder()->limit(rand(1, 2))->get();
            foreach ($doctors as $doctor) {
                $medication->doctors()->attach($doctor->id, [
                    'prescribed_at' => now()->subDays(rand(1, 30))
                ]);
            }
        }
    }
}
