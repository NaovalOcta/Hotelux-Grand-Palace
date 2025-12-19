<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    protected $casts = [
        'gallery_images' => 'array',
        'amenities' => 'array',
        'rate_plans' => 'array',
        'occupancy' => 'array',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'room_id');
    }
}
