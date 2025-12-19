<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $guarded = [];
    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
    ];
    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_id');
    }
}
