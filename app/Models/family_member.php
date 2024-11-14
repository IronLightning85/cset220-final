<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class family_member extends Model
{
    use HasFactory;

    //Disable Timestamps
    public $timestamps = false;

    //Colums we can mass assign
    protected $fillable = [
        'patient_relation',
        'user_id',
    ];
}
