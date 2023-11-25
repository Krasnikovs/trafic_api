<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vehicle extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $table = 'vehicles';

    protected $fillable = [
        'message',
        'topic',
        'timestamp'
    ];
}
