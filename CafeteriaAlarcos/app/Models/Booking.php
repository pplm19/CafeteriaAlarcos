<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'turn_id',
        'description',
        'cancelled',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookingTables()
    {
        return $this->hasMany(BookingTables::class);
    }

    public function tables()
    {
        return $this->belongsToMany(Table::class, 'booking_tables', 'booking_id', 'table_id')
            ->withPivot('guests')
            ->withTimestamps();
    }

    public function turn()
    {
        return $this->belongsTo(Turn::class);
    }
}
