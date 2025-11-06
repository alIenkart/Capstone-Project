<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'package_id',
        'customer_name',
        'customer_id',
        'voucher_id',
        'total_quantity',
        'total_price',
        'status',
        'remarks',
        'id_type',
        'discount_id_image',
        'discount_images',
        'rejection_reason',
        'rejection_category', // Add this line
        'approved_by',
        'approved_at',
        'travel_date',
        
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

    protected $casts = [
        'created_at' => 'datetime',
        'approved_at' => 'datetime',
        'travel_date' => 'datetime',
    ];

    public function package()
    {
        return $this->belongsTo(Packages::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function approvedByUser()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}