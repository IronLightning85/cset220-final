<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class roster extends Model
{
    use HasFactory;

    protected $primaryKey = 'roster_id';
    public $timestamps = false;


    protected $fillable = [
        'date',
        'supervisor_id',
        'doctor_id',
        'caregiver_id_1',
        'caregiver_id_2',
        'caregiver_id_3',
        'caregiver_id_4',
    ];
}
