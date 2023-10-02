<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turn extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date',
        'start',
        'end',
        'description',
        'menu_id'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
