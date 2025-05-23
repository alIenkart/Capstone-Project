<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'package_id',
        'gallery_id',
        'ratings',
        'feedback',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }
}