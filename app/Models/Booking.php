<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class Booking extends Model
{
    use RevisionableTrait;

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
        'rejection_category',
        'approved_by',
        'approved_at',
        'rejected_by',
        'rejected_at',
        'travel_date',
        
        // Package details
        'package_destination',
        'tour_type',
        'duration',
        'start_date',
        'end_date',
        'itinerary',
        
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
        'rejected_at' => 'datetime',
        'travel_date' => 'datetime',
        'itinerary' => 'array',
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
    
    public function rejectedByUser()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }
}