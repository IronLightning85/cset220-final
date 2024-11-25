<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class patient_group extends Model
{
    use HasFactory;

    protected $primaryKey = 'group_id';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
    ];

}
