<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = [
        'name',
        'email',
        'destination',
        'contact_number',
        'adults',
        'children',
        'seniors',
        'subject',
        'message',
    ];
}
