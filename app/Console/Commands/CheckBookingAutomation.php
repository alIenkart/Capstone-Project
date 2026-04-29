<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\AutomationSetting;
use App\Services\NotificationService;
use App\Mail\BookingRejected;
use App\Mail\PaymentReminderMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CheckBookingAutomation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-booking-automation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically process booking warnings and rejections based on automation settings';

    protected NotificationService $notificationService;

    /**
     * Create a new command instance.
     */
    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $settings = AutomationSetting::first();

        if (!$settings || !$settings->is_automation_enabled) {
            $this->info('Automation is disabled or settings not found.');
            return;
        }

        $today = Carbon::now()->startOfDay();
        $pendingBookings = Booking::where('status', 'Pending')->get();

        foreach ($pendingBookings as $booking) {
            if (!$booking->start_date) continue;

            $travelDate = Carbon::parse($booking->start_date)->startOfDay();
            
            // diffInDays with false as second param gives positive if travelDate is in the future
            $diffDays = $today->diffInDays($travelDate, false);

            // 1. Process Rejections (Cancellation)
            if ($diffDays <= $settings->cancellation_days) {
                $this->processRejection($booking, $settings);
                continue;
            }

            // 2. Process Warnings/Reminders
            if ($diffDays <= $settings->warning_days && !$booking->reminder_sent_at) {
                $this->processReminder($booking, $settings);
            }
        }

        $this->info('Booking automation check completed.');
    }

    private function processRejection(Booking $booking, AutomationSetting $settings)
    {
        $booking->update([
            'status' => 'Rejected',
            'rejection_category' => 'Past Due Payment',
            'rejection_reason' => $settings->cancellation_message ?? 'Your booking has been automatically cancelled due to a past due payment.',
            'rejected_at' => now(),
        ]);

        // Send Email
        try {
            Mail::to($booking->customer_email)->send(new BookingRejected($booking));
        } catch (\Exception $e) {
            Log::warning("Automated rejection email failed for booking {$booking->id}: " . $e->getMessage());
        }

        // Create Notification
        $this->notificationService->createRejectedNotification($booking, 'Past Due Payment');
        
        $this->info("Booking #{$booking->id} automatically rejected (Past Due Payment).");
    }

    private function processReminder(Booking $booking, AutomationSetting $settings)
    {
        // Send Email
        try {
            Mail::to($booking->customer_email)->send(new PaymentReminderMail($booking, $settings->cancellation_days));
        } catch (\Exception $e) {
            Log::warning("Automated reminder email failed for booking {$booking->id}: " . $e->getMessage());
        }

        // Create Notification
        $this->notificationService->createPaymentReminderNotification($booking, $settings->cancellation_days);

        // Update timestamp
        $booking->update(['reminder_sent_at' => now()]);

        $this->info("Payment reminder sent for booking #{$booking->id}.");
    }
}
