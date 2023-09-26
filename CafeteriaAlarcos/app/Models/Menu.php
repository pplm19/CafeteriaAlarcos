<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function dishes()
    {
        return $this->belongsToMany(Dish::class, 'dish_menus')->withPivot('order')->orderBy('order');
    }
}
