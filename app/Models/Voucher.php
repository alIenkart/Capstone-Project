<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucher_rate',
        'status',
        'time_stamp',
    ];

    protected $casts = [
        'voucher_rate' => 'integer',
        'status' => 'datetime',
        'time_stamp' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Scope for active vouchers (where status is not null)
    public function scopeActive($query)
    {
        return $query->whereNotNull('status');
    }

    // Scope for inactive vouchers (where status is null)
    public function scopeInactive($query)
    {
        return $query->whereNull('status');
    }

    // Get formatted voucher rate with percentage
    public function getFormattedRateAttribute()
    {
        return $this->voucher_rate . '%';
    }
}