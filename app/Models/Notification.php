<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['customers_id', 'message', 'status'];

    public function customer()
    {
        return $this->belongsTo(Customers::class, 'customers_id');
    }
}
