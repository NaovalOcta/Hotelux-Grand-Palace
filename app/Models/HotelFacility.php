<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelFacility extends Model
{
    protected $table = 'hotel_facilities';
    protected $guarded = [];

    protected $casts = [
        'items' => 'array',
    ];
}
