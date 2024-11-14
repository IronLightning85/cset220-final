<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class patient extends Model
{
    use HasFactory;

    //Disable Timestamps
    public $timestamps = false;

    //Colums we can mass assign
    protected $fillable = [
        'user_id',
        'emergency_contact',
        'contact_relation',
        'family_code',
    ];
}
