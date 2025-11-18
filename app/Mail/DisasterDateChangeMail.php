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

    public function __construct(
        Booking $booking,
        string $packageName,
        string $duration,
        string $currentDate,
        string $proposedDate,
        ?string $reason = null
    ) {
        $this->booking = $booking;
        $this->packageName = $packageName;
        $this->duration = $duration;
        $this->currentDate = $currentDate;
        $this->proposedDate = $proposedDate;
        $this->reason = $reason;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Important: Travel Date Change Due to Disaster - ' . ($this->booking->booking_reference ?? 'Booking'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.disaster-date-change',
            with: [
                'booking' => $this->booking,
                'packageName' => $this->packageName,
                'duration' => $this->duration,
                'currentDate' => $this->currentDate,
                'proposedDate' => $this->proposedDate,
                'reason' => $this->reason,
                'bookingId' => 'B' . str_pad($this->booking->id, 5, '0', STR_PAD_LEFT),
                'customerName' => $this->booking->customer_name,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}