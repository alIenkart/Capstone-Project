<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Venturecraft\Revisionable\RevisionableTrait;

class Packages extends Model
{
    use RevisionableTrait;

    protected $revisionEnabled = true;


    protected $fillable = [
        'destination',
        'region',
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
        'kids_pax_rate',
        'discounted_rate',
        'time_stamp',
        'tour_classification',
    ];

    protected $casts = [
        'itinerary' => 'array',
        'tour_classification' => 'array',
    ];
}