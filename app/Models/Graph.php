<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Graph extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';
    protected $table = 'vehicle';
    protected $guard_name = 'api';
    protected $guarded = [];

    protected $fillable = [
        'vector',
        'position',
        'timestamp'
    ];
}
