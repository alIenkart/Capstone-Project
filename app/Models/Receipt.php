<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = [
        'payment_id',
        'customer_id',
        'approved_by',
        'receipt_date',
        'total_amount',
        'signature_path',
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
}
