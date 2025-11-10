<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;


class Payment extends Model
{
    use RevisionableTrait;

    protected $fillable = [
        'booking_id',
        'customer_id',
        'total_price',
        'payment_history',
        'payment_status',
        'remarks',
        'proof_of_payment',
        'type_of_payment',
        'rejection_category',
        'rejection_reason',
        'rejected_at',
    ];

    protected $casts = [
        'payment_history' => 'array',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public static function createFromBooking($booking)
    {
        if (!$booking || !$booking->id) {
            throw new \Exception('Booking does not exist. Cannot create payment.');
        }

        return $booking->payment()->updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'total_price' => $booking->total_price,
                'amount_paid' => 0,
                'customer_id' => $booking->customer_id,
                'remaining_payment' => $booking->total_price,
                'mode_of_payment' => $booking->mode_of_payment,
                'payment_status' => 'Pending',
                'payment_date' => now(),
            ]
        );
    }
}