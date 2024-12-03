<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class appointment extends Model
{
    use HasFactory;

    protected $primaryKey = 'appointment_id';
    public $timestamps = false;

    protected $fillable = [
        'date',
        'patient_id',
        'doctor_id',
        'comment',
        'morning_med',
        'afternoon_med',
        'night_med',
    ];

}
