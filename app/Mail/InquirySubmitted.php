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
        $logoPath = public_path('storage/logo/Logo.png');
        $iconHeaderPath = public_path('storage/icons/mail-white.png');
        $iconSuccessPath = public_path('storage/icons/ok-green.png');
        $iconMessagePath = public_path('storage/icons/topic-blue.png');
        $isProduction = config('app.env') === 'production';
        $appURL = config('app.url');

        return new Content(
            view: 'emails.inquiry-submitted',
            with: [
                'inquiry' => $this->inquiry,
                'logoPath' => file_exists($logoPath) ? $logoPath : null,
                'iconHeaderPath' => file_exists($iconHeaderPath) ? $iconHeaderPath : null,
                'iconSuccessPath' => file_exists($iconSuccessPath) ? $iconSuccessPath : null,
                'iconMessagePath' => file_exists($iconMessagePath) ? $iconMessagePath : null,
                'isProduction' => $isProduction ?? 'false',
                'appURL' => $appURL ?? 'http://localhost'
            ]
        );
    }
}
