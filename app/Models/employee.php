<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
    use HasFactory;

    //Disable TimeStamps
    public $timestamps = false;

    //Colums we can mass assign
    protected $fillable = [
        'user_id',
        'salary',
    ];
}
