<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;
    protected $table = 'tables' ;
    protected $primaryKey = 'hall-table';
    public $incrementing = false;
    protected $fillable = [
        'tableNumber',
        'hallNumber',
        'active',
        'maxCapacity',
    ];
}
