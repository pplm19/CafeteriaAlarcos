<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingTables extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'table_id',
        'guests',
    ];
}
