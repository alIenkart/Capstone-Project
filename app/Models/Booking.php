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
        'discount_amount',
        'discount_percent',
        
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

    /**
     * Get the package associated with this booking
     */
    public function package()
    {
        return $this->belongsTo(Packages::class);
    }

    /**
     * Get the voucher associated with this booking
     */
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    /**
     * Get the customer who made this booking
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get the admin who approved this booking
     */
    public function approvedByUser()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    
    /**
     * Get the admin who rejected this booking
     */
    public function rejectedByUser()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    /**
     * Get all notifications for this booking
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function cancelBooking()
    {
        $this->update(['status' => 'Cancelled']);

        $this->load('package');

        if ($this->payment) {
            $this->payment->update(['payment_status' => 'Cancelled']);
        }

        if ($this->package) {
            $this->package->available_slot += $this->total_quantity;
            $this->package->save();
        }
    }

    public function rejectBooking(array $data)
    {
        $data['rejected_at'] = now();

        $this->update($data);

        $this->load('package');

        if ($this->package) {
            $this->package->available_slot += $this->total_quantity;
            $this->package->save();
        }
    }


}
