<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpMail;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;

class OtpRegisterController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
        ]);

        // Generate OTP
        $otp = rand(100000, 999999);

        // Save OTP to database
        Otp::updateOrCreate(
            ['email' => $request->email],
            [
                'otp_code' => $otp,
                'expires_at' => now()->addMinutes(5),
            ]
        );

        // Send OTP via Mailtrap
        Mail::to($request->email)->send(new SendOtpMail($otp));

        return response()->json(['message' => 'OTP sent successfully.']);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'required|string|max:255',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'otp_code' => 'required',
        ]);

        $otpRecord = Otp::where('email', $request->email)
                        ->where('otp_code', $request->otp_code)
                        ->where('expires_at', '>', now())
                        ->first();

        if (!$otpRecord) {
            return response()->json(['message' => 'Invalid or expired OTP.'], 400);
        }

        // Create user
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
        ]);

        // Delete OTP after successful verificationw
        $otpRecord->delete();

        return response()->json(['message' => 'Registration successful.']);
    }
}