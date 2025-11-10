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
        'start_date',
        'end_date',
        'tour_duration',
        'image_path',
        'itinerary',
        'terms_condition',
        'exclusions',
        'package_name',
        'capacity',
        'status',
        'pax_rate',
        'kids_pax_rate',
        'discounted_rate',
        'time_stamp',
        'tour_classification',
        'available_slot'
    ];
    
    protected $casts = [
        'itinerary' => 'array',
        'tour_classification' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}