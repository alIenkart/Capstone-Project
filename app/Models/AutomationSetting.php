<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutomationSetting extends Model
{
    protected $fillable = [
        'warning_days',
        'warning_message',
        'cancellation_days',
        'cancellation_message',
        'is_automation_enabled',
    ];

    protected $casts = [
        'is_automation_enabled' => 'boolean',
    ];
}
