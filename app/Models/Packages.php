<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    protected $fillable = [
        'destination',
        'description',
        'tour_duration',
        'image_path',
        'itinerary',
        'terms_condition',
        'exclusions',
        'package_name',
        'capacity',
        'joint_booking',
        'status',
        'pax_rate',
        'discounted_rate',
        'time_stamp',
    ];
}