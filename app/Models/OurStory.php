<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurStory extends Model
{
    use HasFactory;

    protected $table = 'our_story';

    protected $fillable = [
        'name',
        'subtitle',
        'description',
        'image',
    ];
}