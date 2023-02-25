<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHallTable extends Model
{
    use HasFactory;
    protected $table = 'user_hall_tables';
    protected $fillable = [
        'name',
        'user_id',
        'tables',
        'hall',
    ];
    protected $casts = [
        'tables'=>'array',
    ];
}
