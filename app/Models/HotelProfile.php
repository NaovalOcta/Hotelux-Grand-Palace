<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelProfile extends Model
{
    protected $table = 'hotel_profiles';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    protected $casts = [
        'address' => 'array',
        'key_highlights' => 'array',
        'check_in_out_policy' => 'array',
        'contact' => 'array',
        'social_links' => 'array',
        'star_rating' => 'decimal:1',
    ];
}
