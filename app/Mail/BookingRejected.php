<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingRejected extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Booking $booking)
    {
    }

    public function envelope(): Envelope
    {
        $subject = $this->booking->rejection_category === 'Past Due Payment' 
            ? 'Booking Automatically Cancelled - Past Due Payment'
            : 'Booking Rejected - ' . $this->booking->package_destination;

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        // Get logo and convert to Base64
        $logoPath = public_path('storage/logo/Logo.png');
        $logoBase64 = '';
        $mimeType = 'image/png';

        if (file_exists($logoPath)) {
            $imageData = file_get_contents($logoPath);
            $logoBase64 = base64_encode($imageData);
        }

        return new Content(
            view: 'emails.booking-rejected',
            with: [
                'booking' => $this->booking,
                'logoBase64' => $logoBase64,
                'mimeType' => $mimeType,
            ]
        );
    }
}