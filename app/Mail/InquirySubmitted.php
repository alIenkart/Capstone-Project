<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InquirySubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Inquiry $inquiry)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Inquiry Received - ' . ($this->inquiry->subject ?? 'JE Travel & Tours'),
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
            view: 'emails.inquiry-submitted',
            with: [
                'inquiry' => $this->inquiry,
                'logoBase64' => $logoBase64,
                'mimeType' => $mimeType,
            ]
        );
    }
}
