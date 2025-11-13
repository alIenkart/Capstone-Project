<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnalyticsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|object
     */
    public function toArray($request)
    {
        return [
            'packages' => [
                'active_packages' => $this['packages']['active'] ?? 0,
                'inactive_packages' => $this['packages']['inactive'] ?? 0,
            ],
            'bookings' => [
                'approved' => $this['bookings']['approved'] ?? 0,
                'rejected' => $this['bookings']['rejected'] ?? 0,
                'cancelled' => $this['bookings']['cancelled'] ?? 0,
                'pending' => $this['bookings']['pending'] ?? 0,
            ],
        ];
    }
}
