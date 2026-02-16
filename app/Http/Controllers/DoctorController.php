<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display doctor directory.
     */
    public function index()
    {
        $doctors = Doctor::with('medications')->get();
        
        return view('doctors.index', compact('doctors'));
    }

    /**
     * Display doctor profile with linked prescriptions.
     */
    public function show(Doctor $doctor)
    {
        $doctor->load('medications');
        
        return view('doctors.show', compact('doctor'));
    }
}
