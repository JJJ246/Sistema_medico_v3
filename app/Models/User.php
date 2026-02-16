<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'full_name',
        'email',
        'birthdate',
        'password',
        'role',
        'profile_photo_path',
        'mrn',
        'diagnosis',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'birthdate' => 'date',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the medications for the user.
     */
    public function medications()
    {
        return $this->hasMany(Medication::class);
    }

    /**
     * Get adherence logs for this patient through their medications.
     */
    public function adherenceLogs()
    {
        return $this->hasManyThrough(AdherenceLog::class, Medication::class);
    }

    /**
     * Get the achievements for the user.
     */
    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }

    /**
     * Get prescriptions issued by this doctor.
     */
    public function prescribedMedications()
    {
        return $this->hasMany(Prescription::class, 'doctor_id');
    }

    /**
     * Get prescriptions for this patient.
     */
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'patient_id');
    }

    /**
     * Scope for doctors only.
     */
    public function scopeDoctors($query)
    {
        return $query->where('role', 'doctor');
    }

    /**
     * Scope for patients only.
     */
    public function scopePatients($query)
    {
        return $query->where('role', 'patient');
    }

    /**
     * Get the URL to the user's profile photo.
     */
    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo_path
            ? asset('storage/' . $this->profile_photo_path)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }
}
