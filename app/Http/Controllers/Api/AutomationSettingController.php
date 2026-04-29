<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AutomationSetting;
use Illuminate\Http\Request;

class AutomationSettingController extends Controller
{
    public function index()
    {
        $settings = AutomationSetting::first();
        if (!$settings) {
            $settings = AutomationSetting::create([
                'warning_days' => 3,
                'warning_message' => 'Your travel date is approaching. Please ensure your booking is confirmed.',
                'cancellation_days' => 1,
                'cancellation_message' => 'Your booking has been automatically cancelled due to a past due payment.',
                'is_automation_enabled' => false,
            ]);
        }
        return response()->json($settings);
    }

    public function update(Request $request)
    {
        $settings = AutomationSetting::first();
        if (!$settings) {
            $settings = new AutomationSetting();
        }
        $settings->fill($request->all());
        $settings->save();
        return response()->json($settings);
    }
}
