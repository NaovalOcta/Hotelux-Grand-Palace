<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $table = 'room_types';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];
    protected $casts = [
        'gallery_images' => 'array',
        'occupancy' => 'array',
        'amenities' => 'array',
        'rate_plans' => 'array',
    ];

    // Relasi ke Booking
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'room_id');
    }
}
