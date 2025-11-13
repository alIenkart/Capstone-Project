<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReceiptResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'booking_id' => $this->booking_id,
            'customer_name' => $this->booking->customer_name ?? null,
            'customer_email' => $this->booking->customer_email ?? null,
            'customer_phone' => $this->booking->customer_phone ?? null,
            'total_quantity' => $this->booking->total_quantity ?? null,
            'duration' => $this->booking->duration ?? null,
            'start_date' => $this->booking->start_date ?? null,
            'end_date' => $this->booking->end_date ?? null,
            'tour_type' => $this->booking->tour_type ?? null,
            'tour_classification' => $this->booking->package->tour_classification ?? null,
            'package_destination' => $this->booking->package_destination ?? null,
            'mode_of_payment' => $this->payment->mode_of_payment ?? null,
            'type_of_payment' => $this->payment->type_of_payment ?? null,
            'total_price' => $this->booking->total_price ?? null,
            'remaining_balance' => $this->payment->total_price ?? null,
            'payment_history' => $this->payment->payment_history ?? null,
        ];
    }
}
