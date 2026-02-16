<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetPasswordsSeeder extends Seeder
{
    public function run()
    {
        // Doctor / Admin
        $doctor = User::updateOrCreate(
            ['email' => 'admin@medicore.com'],
            [
                'name' => 'Dr. Admin',
                'password' => Hash::make('admin123'),
                'role' => 'doctor', // Assuming 'doctor' is the role for admin in this context, or 'admin'
                'email_verified_at' => now(),
            ]
        );
        $this->command->info("Doctor user (admin@medicore.com) reset with password 'admin123'");

        // Patient
        $patient = User::updateOrCreate(
            ['email' => 'james@patient.com'],
            [
                'name' => 'James Anderson',
                'password' => Hash::make('patient123'),
                'role' => 'patient',
                'email_verified_at' => now(),
                'mrn' => 'MRN-'.rand(1000,9999), // Ensure MRN if creating new
            ]
        );
        $this->command->info("Patient user (james@patient.com) reset with password 'patient123'");
    }
}
