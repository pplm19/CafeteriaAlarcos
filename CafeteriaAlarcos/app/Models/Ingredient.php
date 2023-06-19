<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'i_category_id',
    ];

    public function icategory()
    {
        return $this->belongsTo(ICategory::class, 'i_category_id');
    }
}
