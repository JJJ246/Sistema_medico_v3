<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class RegisterStepOneController extends Controller
{
    /**
     * Display the registration step 1 form.
     */
    public function create()
    {
        return view('auth.register-step-1');
    }

    /**
     * Handle the registration step 1 form submission.
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'birthdate' => ['required', 'date', 'before:-18 years'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'birthdate.before' => 'You must be at least 18 years old to register.',
        ]);

        // Store step 1 data in session
        session([
            'registration_step1' => [
                'full_name' => $request->full_name,
                'email' => $request->email,
                'birthdate' => $request->birthdate,
                'password' => $request->password,
            ]
        ]);

        return redirect()->route('register.step2');
    }
}
