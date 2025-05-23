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
        return $this->belongsTo(Payment::class);
    }
}