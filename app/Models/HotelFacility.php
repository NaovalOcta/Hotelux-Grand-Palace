<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelFacility extends Model
{
    protected $table = 'hotel_facilities';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];
}
