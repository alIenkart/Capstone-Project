<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'payment_id' => $this->id,
            'booking_id' => $this->booking_id,
            'customer_id' => $this->customer_id,
            'total_price' => $this->total_price,
            'payment_history' => $this->payment_history,
            'payment_status' => $this->payment_status,
            'is_fully_paid' => $this->is_fully_paid,
            'type_of_payment' => $this->type_of_payment,
            'mode_of_payment' => $this->mode_of_payment,
            'rejection_category' => $this->rejection_category,
            'rejection_reason' => $this->rejection_reason,
            'rejected_by_name' => trim(optional($this->rejectedByUser)->first_name . ' ' . optional($this->rejectedByUser)->last_name),
            'rejected_at' => $this->rejected_at,
            'remarks' => $this->remarks,
            'approved_by_name' => trim(optional($this->approvedByUser)->first_name . ' ' . optional($this->approvedByUser)->last_name),
            'receipt' => $this->proof_of_payment,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            'booking' => [
                'customer_name' => $this->booking->customer_name ?? null,
                'customer_email' => $this->booking->customer_email ?? null,
                'customer_phone' => $this->booking->customer_phone ?? null,
                'customer_address' => $this->booking->customer_address ?? null,
                'package_destination' => $this->booking->package_destination ?? null,
                'tour_type' => $this->booking->tour_type ?? null,
                'duration' => $this->booking->duration ?? null,
                'start_date' => $this->booking->start_date ?? null,
                'end_date' => $this->booking->end_date ?? null,
                'total_quantity' => $this->booking->total_quantity ?? null,
                'total_price' => $this->booking->total_price ?? null,
                'walk_in' => $this->booking->walk_in ?? null,
            ],

            'package' => [
                'tour_classification' => $this->booking->package->tour_classification ?? null,
            ],
        ];
    }
}
