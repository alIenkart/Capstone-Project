<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'amount_paid',
        'payment_date',
        'payment_status',
        'total_price',
        'remaining_payment',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public static function createFromBooking($booking)
    {
        return self::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'total_price' => $booking->total_price,
                'amount_paid' => 0,
                'remaining_payment' => $booking->total_price,
                'payment_status' => 'Pending',
                'payment_date' => now(),
            ]
        );
    }
}