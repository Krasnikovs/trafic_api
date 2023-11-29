<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vehicle extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';
    protected $table = 'vehicle';
    protected $guard_name = 'api';
    protected $guarded = [];

//    protected $fillable = [
//        'message',
//        'topic_id',
//        'timestamp'
//    ];

    protected $fillable = [
        'vector',
        'position',
        'timestamp'
    ];
}
