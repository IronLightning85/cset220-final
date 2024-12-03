<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientDailyActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'caregiver_id',
        'morning',
        'afternoon',
        'night',
        'breakfast',
        'lunch',
        'dinner',
        'date',
    ];

    // Relationships
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function caregiver()
    {
        return $this->belongsTo(User::class, 'caregiver_id'); // Assuming caregivers are stored in the 'users' table
    }
}
