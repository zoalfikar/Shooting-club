<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salePointsBills extends Model
{
    use HasFactory;
    protected $table = 'sale_points_bills';
    protected $fillable = [
        'sale_point',
        'sale_point_acountant',
        'acountant_name',
        'order',
        'total',
        'inventory',
    ];
    protected function order(): Attribute {
        return new Attribute(
            fn ($value) => json_decode($value , true),
            fn ($value) =>json_encode($value)
        );
    }

}
