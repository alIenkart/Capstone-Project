<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Notification;
use Carbon\Carbon;

class NotificationService
{
    /**
     * Format currency amount
     */
    private function formatCurrency(float $amount): string
    {
        return '₱' . number_format($amount, 2);
    }

    /**
     * Format date — ✅ now safely handles null values
     */
    private function formatDate(?string $date): string
    {
        if (empty($date)) {
            return now()->format('F j, Y');
        }

        try {
            return Carbon::parse($date)->format('F j, Y');
        } catch (\Exception $e) {
            \Log::warning('Invalid date passed to NotificationService::formatDate: ' . $e->getMessage());
            return now()->format('F j, Y');
        }
    }

    /**
     * Format time
     */
    private function formatTime(string $datetime): string
    {
        return Carbon::parse($datetime)->format('g:i A');
    }

    /**
     * Generate booking ID format
     */
    private function formatBookingId(int $id): string
    {
        return 'B' . str_pad($id, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Create notification for approved booking
     */
    public function createApprovedNotification(Booking $booking): Notification
    {
        $packageName = $booking->package_destination ?? 'Unknown Package';
        $duration = $booking->duration ?? '0';
        $travelDate = $this->formatDate($booking->travel_date);
        $amount = $this->formatCurrency($booking->total_price ?? 0);
        $bookingId = $this->formatBookingId($booking->id);

        $title = 'Your Booking is Confirmed';
        $message = "Your booking for {$packageName} - {$duration} Day/s on {$travelDate} has been confirmed. " .
            "Please proceed with the payment of {$amount} using the QR code provided in the My Bookings page. " .
            "Make sure to upload your payment receipt for verification. Thank you.";

        return Notification::create([
            'user_id' => $booking->customer_id,
            'booking_id' => $booking->id,
            'type' => 'booking_approved',
            'title' => $title,
            'message' => $message,
        ]);
    }

    /**
     * Create notification for rejected booking
     */
    public function createRejectedNotification(Booking $booking, ?string $rejectionCategory = null): Notification
    {
        $packageName = $booking->package_destination ?? 'Unknown Package';
        $duration = $booking->duration ?? '0';
        $travelDate = $this->formatDate($booking->travel_date);
        $bookingId = $this->formatBookingId($booking->id);

        $title = 'Your Booking is Rejected';
        $message = "Your booking for {$packageName} - {$duration} Day/s on {$travelDate} has been rejected. ";

        if ($rejectionCategory) {
            $message .= "Reason: {$rejectionCategory}. ";
        }

        $message .= "Please check your email for more details or contact us. Thank you.";

        return Notification::create([
            'user_id' => $booking->customer_id,
            'booking_id' => $booking->id,
            'type' => 'booking_rejected',
            'title' => $title,
            'message' => $message,
        ]);
    }

    /**
     * Get unread notifications for a user
     */
    public function getUnreadNotifications(int $userId)
    {
        return Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get all notifications for a user
     */
    public function getAllNotifications(int $userId, int $limit = 20)
    {
        return Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(int $notificationId): bool
    {
        $notification = Notification::find($notificationId);

        if ($notification) {
            $notification->markAsRead();
            return true;
        }

        return false;
    }

    /**
     * Mark all notifications as read for a user
     */
    public function markAllAsRead(int $userId): int
    {
        return Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
    }

    /**
     * Get unread count for a user
     */
    public function getUnreadCount(int $userId): int
    {
        return Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->count();
    }
}