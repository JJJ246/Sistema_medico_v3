<?php

namespace App\Policies;

use App\Models\Medication;
use App\Models\User;

class MedicationPolicy
{
    /**
     * Determine if the user can update the medication.
     */
    public function update(User $user, Medication $medication): bool
    {
        return $user->id === $medication->user_id;
    }

    /**
     * Determine if the user can delete the medication.
     */
    public function delete(User $user, Medication $medication): bool
    {
        return $user->id === $medication->user_id;
    }
}
