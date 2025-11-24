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
        'approved_by',
        'rejected_by',
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
        $total_price = $booking->original_amount;
        if (!is_null($booking->discount_amount)) {
            $total_price -= $booking->discount_amount;
        }
        return self::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'total_price' => $total_price,
                'amount_paid' => 0,
                'customer_id' => $booking->customer_id,
                'remaining_payment' => $total_price,
                'mode_of_payment' => $booking->mode_of_payment,
                'payment_status' => 'Pending',
                'payment_date' => now(),
            ]
        );
    }

    public function approvedByUser()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejectedByUser()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }
}