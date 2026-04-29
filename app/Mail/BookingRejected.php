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
        $logoPath = public_path('storage/logo/Logo.png');
        $iconHeaderPath = public_path('storage/icons/cancel-white.png');
        $iconErrorPath = public_path('storage/icons/error-red.png');
        $iconNotesPath = public_path('storage/icons/topic-blue.png');
        $isProduction = config('app.env') === 'production';
        $appURL = config('app.url');

        return new Content(
            view: 'emails.booking-rejected',
            with: [
                'booking' => $this->booking,
                'logoPath' => file_exists($logoPath) ? $logoPath : null,
                'iconHeaderPath' => file_exists($iconHeaderPath) ? $iconHeaderPath : null,
                'iconErrorPath' => file_exists($iconErrorPath) ? $iconErrorPath : null,
                'iconNotesPath' => file_exists($iconNotesPath) ? $iconNotesPath : null,
                'isProduction' => $isProduction ?? 'false',
                'appURL' => $appURL ?? 'http://localhost'
            ]
        );
    }
}