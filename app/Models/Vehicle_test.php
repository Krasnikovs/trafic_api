<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle_test extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';
    protected $guard_name = 'api';
    protected $guarded = [];

    protected $fillable = [
        'message',
        'topic',
        'timestamp'
    ];
}
