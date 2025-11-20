<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DisasterDateChangeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Booking $booking;
    public string $packageName;
    public string $duration;
    public string $currentDate;
    public string $proposedDate;
    public ?string $reason;
    public bool $isPaymentConfirmed;

    public function __construct(
        Booking $booking,
        string $packageName,
        string $duration,
        string $currentDate,
        string $proposedDate,
        ?string $reason = null,
        bool $isPaymentConfirmed = false
    ) {
        $this->booking = $booking;
        $this->packageName = $packageName;
        $this->duration = $duration;
        $this->currentDate = $currentDate;
        $this->proposedDate = $proposedDate;
        $this->reason = $reason;
        $this->isPaymentConfirmed = $isPaymentConfirmed;
    }

    public function envelope(): Envelope
    {
        $subject = $this->isPaymentConfirmed 
            ? 'Booking Confirmed & Paid - Rescheduling Notice'
            : 'Booking Confirmed - Rescheduling Notice';

        return new Envelope(
            subject: $subject . ' - ' . ($this->booking->booking_reference ?? 'Booking'),
        );
    }

    public function content(): Content
    {
        $view = $this->isPaymentConfirmed 
            ? 'emails.disaster-date-change-paid'
            : 'emails.disaster-date-change-pending';

        return new Content(
            view: $view,
            with: [
                'booking' => $this->booking,
                'packageName' => $this->packageName,
                'duration' => $this->duration,
                'currentDate' => $this->currentDate,
                'proposedDate' => $this->proposedDate,
                'reason' => $this->reason,
                'bookingId' => 'B' . str_pad($this->booking->id, 5, '0', STR_PAD_LEFT),
                'customerName' => $this->booking->customer_name,
                'isPaymentConfirmed' => $this->isPaymentConfirmed,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}