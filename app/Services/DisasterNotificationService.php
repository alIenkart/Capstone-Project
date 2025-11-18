<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Notification;
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

    public function sendDisasterDateChangeNotification(
        Booking $booking,
        ?string $newTravelDate = null,
        ?string $reason = null
    ): array {
        try {
            $packageName = $booking->package_destination ?? 'Unknown Package';
            $duration = $booking->duration ?? '0';
            $currentDate = $this->formatDate($booking->travel_date);
            $proposedDate = $newTravelDate 
                ? $this->formatDate($newTravelDate)
                : 'To be announced';
            $bookingId = $this->formatBookingId($booking->id);

            $notification = $this->createDisasterNotification(
                $booking,
                $packageName,
                $duration,
                $currentDate,
                $proposedDate,
                $reason
            );

            $this->sendDisasterEmail(
                $booking,
                $packageName,
                $duration,
                $currentDate,
                $proposedDate,
                $reason
            );

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
        string $proposedDate,
        ?string $reason
    ): Notification {
        $title = 'Important: Travel Date Change Due to Disaster';
        $message = "Your booking for {$packageName} - {$duration} Day/s on {$currentDate} has been postponed due to safety advisories. ".
            "Please check your registered email for details and contact us. " .
            "immediately to select a new travel date. Your previous payment remains valid and secure. ";

        if ($reason) {
            $message .= "Details: {$reason}. ";
        }

        $message .= "Please check your email and contact us immediately to confirm or discuss alternative dates. We appreciate your understanding.";

        return Notification::create([
            'user_id' => $booking->customer_id,
            'booking_id' => $booking->id,
            'type' => 'disaster_date_change',
            'title' => $title,
            'message' => $message,
        ]);
    }

    private function sendDisasterEmail(
        Booking $booking,
        string $packageName,
        string $duration,
        string $currentDate,
        string $proposedDate,
        ?string $reason
    ): void {
        try {
            Mail::to($booking->customer_email)
                ->send(new DisasterDateChangeMail(
                    $booking,
                    $packageName,
                    $duration,
                    $currentDate,
                    $proposedDate,
                    $reason
                ));

            \Log::info("Disaster notification email sent to {$booking->customer_email} for booking {$booking->id}");
        } catch (\Exception $e) {
            \Log::error("Failed to send disaster email: " . $e->getMessage());
            throw $e;
        }
    }
}