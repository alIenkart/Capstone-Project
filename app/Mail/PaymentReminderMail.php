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

        $logoPath = public_path('storage/logo/Logo.png');
        $iconPath = public_path('storage/icons/clock-white.png');
        $isProduction = config('app.env') === 'production';
        $appURL = config('app.url');

        return new Content(
            view: 'emails.payment-reminder',
            with: [
                'booking' => $this->booking,
                'packageName' => $this->booking->package_destination ?? 'Unknown Package',
                'duration' => $this->booking->duration ?? '0',
                'travelDate' => date('F d, Y', strtotime($this->booking->start_date)),
                'dueDate' => $dueDateObj->format('F d, Y'),
                'cancellationDays' => $this->cancellationDays,
                'logoPath' => file_exists($logoPath) ? $logoPath : null,
                'iconPath' => file_exists($iconPath) ? $iconPath : null,
                'isProduction' => $isProduction ?? 'false',
                'appURL' => $appURL ?? 'http://localhost'
            ],
        );
    }
}
