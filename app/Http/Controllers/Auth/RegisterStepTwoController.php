<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterStepTwoController extends Controller
{
    /**
     * Display the registration step 2 form.
     */
    public function create()
    {
        // Ensure step 1 is completed
        if (!session()->has('registration_step1')) {
            return redirect()->route('register.step1');
        }

        return view('auth.register-step-2');
    }

    /**
     * Handle the registration step 2 form submission and create user.
     */
    public function store(Request $request)
    {
        // Ensure step 1 is completed
        if (!session()->has('registration_step1')) {
            return redirect()->route('register.step1');
        }

        // Get step 1 data from session
        $step1Data = session('registration_step1');

        // Create the user with combined data
        $user = User::create([
            'name' => $step1Data['full_name'], // Laravel compatibility
            'full_name' => $step1Data['full_name'],
            'email' => $step1Data['email'],
            'birthdate' => $step1Data['birthdate'],
            'password' => Hash::make($step1Data['password']),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Clear registration session data
        session()->forget('registration_step1');

        return redirect(route('dashboard', absolute: false));
    }
}
