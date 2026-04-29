<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Receipt;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\BookingRejected;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        return response()->json(Booking::all());
    }

    public function getBookingsByUser(Request $request)
    {
        $userId = $request->query('user_id');

        if (!$userId) {
            return response()->json(['message' => 'Missing user_id parameter'], 400);
        }

        $bookings = Booking::where('customer_id', $userId)->get();
        return response()->json($bookings);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        // Decode itinerary JSON if passed as a string
        if ($request->has('itinerary') && is_string($request->itinerary)) {
            $decoded = json_decode($request->itinerary, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $data['itinerary'] = $decoded;
            }
        }

        $validated = validator($data, [
            'package_id' => 'required|exists:packages,id',
            'package_name' => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',
            'customer_id' => 'required|exists:users,id',
            'voucher_id' => 'nullable|string',
            'total_quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'status' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:1000',
            'id_type' => 'nullable|string|max:255',
            'discount_id_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'walk_in' => 'nullable|boolean',
            'approved_by' => 'nullable|exists:users,id',

            // Package details
            'package_destination' => 'nullable|string|max:255',
            'tour_classification'=> 'nullable|string|max:255',
            'tour_type' => 'nullable|string|max:255',
            'duration' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'travel_date' => 'nullable|date',

            // Itinerary (array of objects)
            'itinerary' => 'required|array',
            'itinerary.*.id' => 'nullable|integer',
            'itinerary.*.content' => 'nullable|string|max:2000',

            // Pricing details
            'adults_quantity' => 'nullable|integer|min:0',
            'kids_quantity' => 'nullable|integer|min:0',
            'adult_rate' => 'nullable|numeric|min:0',
            'kids_rate' => 'nullable|numeric|min:0',
            'adult_total_amount' => 'nullable|numeric|min:0',
            'kids_total_amount' => 'nullable|numeric|min:0',
            'original_amount' => 'nullable|numeric|min:0',

            // Extra fee details for exclusive tours
            'extra_days' => 'nullable|integer|min:0',
            'adult_extra_fee' => 'nullable|numeric|min:0',
            'kids_extra_fee' => 'nullable|numeric|min:0',
            'total_extra_fee' => 'nullable|numeric|min:0',

            // Customer contact details
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:255',
            'customer_address' => 'nullable|string|max:500',
        ])->validate();

        // Handle single discount ID image upload
        if ($request->hasFile('discount_id_image')) {
            $path = $request->file('discount_id_image')->store('discount_ids', 'public');
            $validated['discount_id_image'] = $path;
        }

        // Handle multiple discount images
        if ($request->hasFile('discount_images')) {
            $discountImagePaths = [];
            foreach ($request->file('discount_images') as $file) {
                $path = $file->store('discount_ids', 'public');
                $discountImagePaths[] = $path;
            }
            $validated['discount_images'] = json_encode($discountImagePaths);
        }

        // Default status
        $validated['status'] = $validated['status'] ?? 'Pending';

        if ($validated['walk_in'] === true) {
            $validated = $this->handleWalkInBooking($validated);
        }

        $booking = Booking::create($validated);

        if ($booking->status === 'Pending' && !$booking->walk_in) {
            $this->runImmediateAutomation($booking);
            $booking->refresh();
        }

        if ($booking->walk_in === true) {
            $payment = Payment::approvePayment($booking);
            Receipt::createReceipt($payment, $booking->customer_id);
        }

        return response()->json([
            'message' => 'Booking created successfully.',
            'data' => $booking
        ], 201);
    }

    private function handleWalkInBooking($data)
    {
        $data['status'] = 'Approved';
        $data['approved_at'] = now();

        return $data;
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pending,Approved,Rejected,Cancelled',
            'id_type' => 'nullable|string|max:255',
            'total_price' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|integer|min:0',
            'discount_percent' => 'nullable|integer|min:0',
            'remarks' => 'nullable|string|max:1000',
            'rejection_reason' => 'nullable|string|max:1000',
            'rejection_category' => 'nullable|string|max:255',
            'approved_by' => 'nullable|exists:users,id',
            'rejected_by' => 'nullable|exists:users,id',
        ]);

        $booking = Booking::findOrFail($id);
        $oldStatus = $booking->status;

        DB::beginTransaction();

        try {
            if ($validated['status'] === 'Approved') {
                $response = $this->processPackageSlotUpdate($booking);

                if ($response instanceof \Illuminate\Http\JsonResponse) {
                    return $response;
                }

                $validated['approved_at'] = now();
                $booking->update($validated);

                // Create payment record
                Payment::createFromBooking($booking);

                // Create notification (only if status changed)
                if ($oldStatus !== 'Approved') {
                    $this->notificationService->createApprovedNotification($booking);
                }
            }

            if ($validated['status'] === 'Rejected') {
                $validated['rejected_at'] = now();
                $booking->update($validated);

                // Send rejection email
                try {
                    Mail::to($booking->customer_email)->send(new \App\Mail\BookingRejected($booking));
                } catch (\Exception $e) {
                    \Log::warning('Rejection email failed: ' . $e->getMessage());
                }

                // Create notification (only if status changed)
                if ($oldStatus !== 'Rejected') {
                    $this->notificationService->createRejectedNotification(
                        $booking,
                        $validated['rejection_category'] ?? null
                    );
                }
            }

            if ($validated['status'] === 'Pending') {
                $booking->update($validated);
            }

            if ($validated['status'] === 'Cancelled') {
                $booking->update($validated);

                if ($booking->payment) {
                    $booking->payment->update(['payment_status' => 'Cancelled']);
                }
            }

            if (isset($validated['discount_amount']) && $validated['discount_amount'] == 0) {
                $validated['discount_amount'] = null;
                $validated['discount_percent'] = null;
            }
        
            DB::commit();

            return response()->json([
                'message' => 'Booking updated successfully.',
                'data' => $booking
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Booking update failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to update booking.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function sendPaymentReminder(Request $request, $id)
    {
        try {
            $booking = Booking::findOrFail($id);
            
            $settings = \App\Models\AutomationSetting::first();
            $cancellationDays = $settings ? $settings->cancellation_days : 3;

            // Send Email
            try {
                Mail::to($booking->customer_email)->send(new \App\Mail\PaymentReminderMail($booking, $cancellationDays));
            } catch (\Exception $e) {
                \Log::warning('Payment reminder email failed: ' . $e->getMessage());
            }

            // Create Notification
            $this->notificationService->createPaymentReminderNotification($booking, $cancellationDays);

            // Update timestamp
            $booking->update(['reminder_sent_at' => now()]);

            return response()->json(['message' => 'Payment reminder sent successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to send payment reminder.', 'error' => $e->getMessage()], 500);
        }
    }

    private function runImmediateAutomation(Booking $booking)
    {
        $settings = \App\Models\AutomationSetting::first();
        if (!$settings || !$settings->is_automation_enabled) return;

        $today = now()->startOfDay();
        if (!$booking->start_date) return;
        
        $travelDate = \Carbon\Carbon::parse($booking->start_date)->startOfDay();
        $diffDays = $today->diffInDays($travelDate, false);

        if ($diffDays <= $settings->cancellation_days) {
            $booking->update([
                'status' => 'Rejected',
                'rejection_category' => 'Past Due Payment',
                'rejection_reason' => $settings->cancellation_message ?? 'Your booking has been automatically cancelled due to a past due payment.',
                'rejected_at' => now(),
            ]);

            try {
                \Illuminate\Support\Facades\Mail::to($booking->customer_email)->send(new \App\Mail\BookingRejected($booking));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning("Immediate auto-rejection email failed for booking {$booking->id}: " . $e->getMessage());
            }

            $this->notificationService->createRejectedNotification($booking, 'Past Due Payment');
        } elseif ($diffDays <= $settings->warning_days) {
            try {
                \Illuminate\Support\Facades\Mail::to($booking->customer_email)->send(new \App\Mail\PaymentReminderMail($booking, $settings->cancellation_days));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning("Immediate auto-reminder email failed for booking {$booking->id}: " . $e->getMessage());
            }

            $this->notificationService->createPaymentReminderNotification($booking, $settings->cancellation_days);
            $booking->update(['reminder_sent_at' => now()]);
        }
    }

    private function processPackageSlotUpdate(Booking $booking)
    {
        $package = $booking->package;
        $tour_type = $booking->tour_type;
        $total_quantity = $booking->total_quantity;
        $available_slot = $package->available_slot;

        if($tour_type === 'Exclusive'){
            return true;
        }
        
        if ($total_quantity > $available_slot) {
            throw ValidationException::withMessages([
                'total_quantity' => "The booking quantity ({$total_quantity}) exceeds the available slots ({$available_slot})."
            ]);
        }

        return true;
    }
}
