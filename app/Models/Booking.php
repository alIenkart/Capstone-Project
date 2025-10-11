<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'package_id',
        'customer_name',
        'voucher_id',
        'total_quantity',
        'total_price',
        'status',
        'remarks',
        'id_type',
        'discount_id_image',
        'discount_images',
        
        // Package details
        'package_destination',
        'tour_type',
        'duration',
        'start_date',
        'end_date',
        
        // Pricing details
        'adults_quantity',
        'kids_quantity',
        'adult_rate',
        'kids_rate',
        'adult_total_amount',
        'kids_total_amount',
        'original_amount',
        
        // Customer contact details
        'customer_email',
        'customer_phone',
        'customer_address',
    ];

    public function package()
    {
        return $this->belongsTo(Packages::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
