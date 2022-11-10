<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;
    protected $table = 'halls' ;
    protected $primaryKey = 'hallNumber';
    public $incrementing = false;
    protected $fillable = ['hallNumber','hallName','description','active','maxCapacity'];


}
