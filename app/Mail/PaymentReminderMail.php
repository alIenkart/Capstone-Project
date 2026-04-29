<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentReminderMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Booking $booking;
    public int $cancellationDays;

    public function __construct(Booking $booking, int $cancellationDays)
    {
        $this->booking = $booking;
        $this->cancellationDays = $cancellationDays;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Reminder - ' . ($this->booking->booking_reference ?? 'Booking #' . $this->booking->id),
        );
    }

    public function content(): Content
    {
        $dueDateObj = new \DateTime($this->booking->start_date);
        $dueDateObj->modify("-{$this->cancellationDays} days");

        // Get logo and convert to Base64
        $logoPath = public_path('storage/logo/Logo.png');
        $logoBase64 = '';
        $mimeType = 'image/png';

        if (file_exists($logoPath)) {
            $imageData = file_get_contents($logoPath);
            $logoBase64 = base64_encode($imageData);
        }
        
        return new Content(
            view: 'emails.payment-reminder',
            with: [
                'booking' => $this->booking,
                'packageName' => $this->booking->package_destination ?? 'Unknown Package',
                'duration' => $this->booking->duration ?? '0',
                'travelDate' => date('F d, Y', strtotime($this->booking->start_date)),
                'dueDate' => $dueDateObj->format('F d, Y'),
                'cancellationDays' => $this->cancellationDays,
                'logoBase64' => $logoBase64,
                'mimeType' => $mimeType,
            ],
        );
    }
}
