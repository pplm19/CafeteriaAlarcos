<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'maxNumber',
        'minNumber',
        'description',
    ];

    public function bookingTables()
    {
        return $this->hasMany(BookingTables::class);
    }

    public function bookings()
    {
        return $this->belongsToMany(Table::class, 'booking_tables', 'table_id', 'booking_id')
            ->withPivot('guests')
            ->withTimestamps();
    }
}
