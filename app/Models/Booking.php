<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'package_id',
        'customer_id',
        'discount_id',
        'voucher_id',
        'total_quantity',
        'total_price',
        'booking_date',
    ];

    public function package()
    {
        return $this->belongsTo(Packages::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
