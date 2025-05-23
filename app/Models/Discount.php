<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'booking_id',
        'image_id',
        'status',
        'id_type',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}