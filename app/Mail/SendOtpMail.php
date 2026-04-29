<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function build()
    {
        $logoPath = public_path('storage/logo/Logo.png');
        $iconPath = public_path('storage/icons/lock-white.png');
        $isProduction = config('app.env') === 'production';
        $appURL = config('app.url');

        return $this->subject('Your Registration OTP Code')
                    ->view('emails.otp')
                    ->with([
                        'otp' => $this->otp,
                        'logoPath' => file_exists($logoPath) ? $logoPath : null,
                        'iconPath' => file_exists($iconPath) ? $iconPath : null,
                        'isProduction' => $isProduction ?? 'false',
                        'appURL' => $appURL ?? 'http://localhost'
                    ]);
    }
}