<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    
    //Assign Primary Key, turn off timestamps
    protected $primaryKey = 'role_id';
    public $timestamps = false;

    //Colums we can mass assign
    protected $fillable = [
        'role_name',
        'level',
    ];

}
