<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    // 1. Crear el Administrador (Doctor)
    \App\Models\User::create([
        'name' => 'Dr. Alejandro Vargas',
        'full_name' => 'Alejandro Vargas',
        'email' => 'admin@medicore.com',
        'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
        'birthdate' => '1980-01-01',
        'role' => 'admin',
        'profile_photo_path' => 'profile-photos/doctor.jpg', // Added
    ]);

    // 2. Crear Paciente Maria (con diagnóstico de tus artículos)
    \App\Models\User::create([
        'name' => 'Maria Gonzalez',
        'full_name' => 'Maria Gonzalez',
        'email' => 'maria@patient.com',
        'password' => \Illuminate\Support\Facades\Hash::make('patient123'),
        'birthdate' => '1992-05-20',
        'role' => 'patient',
        'diagnosis' => 'Displasia de Grado I',
        'profile_photo_path' => 'profile-photos/maria.png', // Added
    ]);

    // 3. Crear Paciente James
    \App\Models\User::create([
        'name' => 'James Anderson',
        'full_name' => 'James Anderson',
        'email' => 'james@patient.com',
        'password' => \Illuminate\Support\Facades\Hash::make('patient123'),
        'birthdate' => '1980-11-15',
        'role' => 'patient',
        'diagnosis' => 'Metaplasia Escamosa',
        'profile_photo_path' => 'profile-photos/james.png', // Added
    ]);

    $this->call([
        MedicationSeeder::class,
    ]);
}
}
