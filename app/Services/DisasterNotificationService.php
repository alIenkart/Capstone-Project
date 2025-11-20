<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Notification;
use App\Models\Payment;
use App\Mail\DisasterDateChangeMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class DisasterNotificationService
{
    private function formatCurrency(float $amount): string
    {
        return '₱' . number_format($amount, 2);
    }

    private function formatDate(?string $date): string
    {
        if (empty($date)) {
            return now()->format('F j, Y');
        }

        try {
            return Carbon::parse($date)->format('F j, Y');
        } catch (\Exception $e) {
            \Log::warning('Invalid date passed to DisasterNotificationService::formatDate: ' . $e->getMessage());
            return now()->format('F j, Y');
        }
    }

    private function formatBookingId(int $id): string
    {
        return 'B' . str_pad($id, 5, '0', STR_PAD_LEFT);
    }

    private function isPaymentConfirmed(Booking $booking): bool
    {
        $payment = Payment::where('booking_id', $booking->id)
            ->whereIn('payment_status', ['Approved', 'Down Payment Approved'])
            ->latest()
            ->first();

        if ($payment) {
            \Log::info("Payment found for booking {$booking->id}: Status = {$payment->payment_status}");
            return true;
        }

        $isConfirmed = !empty($booking->payment_confirmed_at);
        \Log::info("Payment not found in payments table for booking {$booking->id}. Using payment_confirmed_at: " . ($isConfirmed ? 'Yes' : 'No'));
        
        return $isConfirmed;
    }

    public function sendDisasterDateChangeNotification(
        Booking $booking,
        ?string $newTravelDate = null,
        ?string $reason = null,
        ?bool $forcePaymentConfirmed = null
    ): array {
        try {
            $travelDate = $booking->start_date ?? $booking->travel_date ?? now();
            
            $packageName = $booking->package_destination ?? 'Your Package';
            $duration = $booking->duration ?? '0';
            $currentDate = $this->formatDate($travelDate);
            $proposedDate = $newTravelDate 
                ? $this->formatDate($newTravelDate)
                : 'To be announced';
            $bookingId = $this->formatBookingId($booking->id);
            
            $isPaymentConfirmed = $forcePaymentConfirmed !== null 
                ? $forcePaymentConfirmed 
                : $this->isPaymentConfirmed($booking);

            \Log::info("Sending disaster notification for booking {$booking->id}. Payment Confirmed: " . ($isPaymentConfirmed ? 'Yes' : 'No'));

            $notification = $this->createDisasterNotification(
                $booking,
                $packageName,
                $duration,
                $currentDate,
                $isPaymentConfirmed
            );

            $this->sendDisasterEmail(
                $booking,
                $packageName,
                $duration,
                $currentDate,
                $proposedDate,
                $reason,
                $isPaymentConfirmed
            );

            \Log::info("Disaster notification created for booking {$booking->id}");

            return [
                'success' => true,
                'message' => 'Disaster notification and email sent successfully',
                'notification_id' => $notification->id,
            ];
        } catch (\Exception $e) {
            \Log::error('Error sending disaster notification: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to send disaster notification: ' . $e->getMessage(),
            ];
        }
    }

    private function createDisasterNotification(
        Booking $booking,
        string $packageName,
        string $duration,
        string $currentDate,
        bool $isPaymentConfirmed
    ): Notification {
        if ($isPaymentConfirmed) {
            $title = 'Booking Confirmed & Paid - Rescheduling Notice';
            $message = "Your booking for {$packageName} - {$duration} Day/s on {$currentDate} has been rescheduled due to safety advisories. " .
                "Your status remains CONFIRMED & PAID. Your payment is safe. Please contact us immediately to select a new travel date.";
        } else {
            $title = 'Booking Confirmed - Rescheduling Notice';
            $message = "Your booking for {$packageName} - {$duration} Day/s on {$currentDate} has been rescheduled due to safety advisories. " .
                "Your booking is CONFIRMED, but your Payment is still PENDING. " .
                "Please contact us to select a new date and settle your payment to secure your slot.";
        }

        return Notification::create([
            'user_id' => $booking->customer_id,
            'booking_id' => $booking->id,
            'type' => 'disaster_date_change',
            'title' => $title,
            'message' => $message,
            'is_read' => false,
        ]);
    }

    private function sendDisasterEmail(
        Booking $booking,
        string $packageName,
        string $duration,
        string $currentDate,
        string $proposedDate,
        ?string $reason,
        bool $isPaymentConfirmed
    ): void {
        try {
            if (!$booking->customer_email) {
                throw new \Exception("Customer email is missing for booking {$booking->id}");
            }

            Mail::to($booking->customer_email)
                ->send(new DisasterDateChangeMail(
                    $booking,
                    $packageName,
                    $duration,
                    $currentDate,
                    $proposedDate,
                    $reason,
                    $isPaymentConfirmed
                ));

            \Log::info("Disaster notification email sent to {$booking->customer_email} for booking {$booking->id}");
        } catch (\Exception $e) {
            \Log::error("Failed to send disaster email to {$booking->customer_email}: " . $e->getMessage());
            throw $e;
        }
    }
}