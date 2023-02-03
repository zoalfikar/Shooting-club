<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $table = "menu_items";
    protected $fillable = [
        'title',
        'section',
        'description',
        'active',
        'price',
        'unit',
        'fragmentable',
        'pace',
    ];
    public function section()
    {
        return $this->belongsTo("App\Models\MenuSection","section");
    }
}
