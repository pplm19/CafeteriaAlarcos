<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DishAllergen extends Model
{
    use HasFactory;

    protected $fillable = [
        'dish_id',
        'allergen_id',
    ];
}
