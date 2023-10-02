<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Dish extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'recipe',
        'description',
        'type_id',
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'ingredient_dishes');
    }

    public function dcategories(): BelongsToMany
    {
        return $this->belongsToMany(DCategory::class, 'dish_categories');
    }

    public function allergens(): BelongsToMany
    {
        return $this->belongsToMany(Allergen::class, 'dish_allergens');
    }

    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class, 'dish_menus');
    }
}
