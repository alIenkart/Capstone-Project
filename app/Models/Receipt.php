<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Receipt extends Model
{
    protected $fillable = [
        'payment_id',
        'customer_id',
        'approved_by',
        'booking_id'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
    
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public static function createReceipt($payment, $id)
    {
        \Log::info('Creating receipt for payment ID: ' . $payment->id . ' by user ID: ' . $id);
        return self::updateOrCreate(
            ['payment_id' => $payment->id],
            [
                'booking_id' => $payment->booking_id,
                'customer_id' => $payment->booking->customer_id,
                'approved_by' => $id,
            ]
        );
    }

}
