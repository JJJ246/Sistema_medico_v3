<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
            [
                'name' => 'Dr. Alejandro Vargas',
                'specialty' => 'General Medicine',
                'photo_path' => null,
                'email' => 'a.vargas@hospital.com',
                'phone' => '+1 (555) 123-4567'
            ],
            [
                'name' => 'Dr. Alejas Comela',
                'specialty' => 'Cardiology',
                'photo_path' => null,
                'email' => 'a.comela@hospital.com',
                'phone' => '+1 (555) 234-5678'
            ],
            [
                'name' => 'Dr. Maria Antral',
                'specialty' => 'Endocrinology',
                'photo_path' => null,
                'email' => 'm.antral@hospital.com',
                'phone' => '+1 (555) 345-6789'
            ],
            [
                'name' => 'Dr. Hennon Gaper',
                'specialty' => 'Internal Medicine',
                'photo_path' => null,
                'email' => 'h.gaper@hospital.com',
                'phone' => '+1 (555) 456-7890'
            ],
        ];

        foreach ($doctors as $doctor) {
            Doctor::create($doctor);
        }
    }
}
