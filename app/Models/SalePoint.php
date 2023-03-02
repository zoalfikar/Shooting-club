<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalePoint extends Model
{
    use HasFactory;
    protected $table = 'sale_points' ;
    protected $fillable = ['name','maxEmployeesNumber','active'];

}
