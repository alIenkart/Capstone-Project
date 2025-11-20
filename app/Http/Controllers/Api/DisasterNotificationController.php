<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\DisasterNotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DisasterNotificationController extends Controller
{
    protected DisasterNotificationService $disasterNotificationService;

    public function __construct(DisasterNotificationService $disasterNotificationService)
    {
        $this->disasterNotificationService = $disasterNotificationService;
    }

    public function sendDisasterNotification(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'booking_id' => 'required|integer|exists:bookings,id',
                'new_travel_date' => 'nullable|date_format:Y-m-d',
                'reason' => 'nullable|string|max:500',
                'payment_status' => 'nullable|string',
            ]);

            $booking = Booking::findOrFail($validated['booking_id']);

            if (!$booking->customer_email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking does not have a valid customer email address',
                ], 400);
            }

            $forcePaymentConfirmed = null;
            if (!empty($validated['payment_status'])) {
                $paymentStatus = $validated['payment_status'];
                
                $forcePaymentConfirmed = in_array($paymentStatus, ['Approved', 'Down Payment Approved']);
                
                \Log::info("Payment status from request: {$paymentStatus}, Force confirmed: " . ($forcePaymentConfirmed ? 'Yes' : 'No'));
            }

            $result = $this->disasterNotificationService->sendDisasterDateChangeNotification(
                $booking,
                $validated['new_travel_date'] ?? null,
                $validated['reason'] ?? null,
                $forcePaymentConfirmed
            );

            if ($result['success']) {
                return response()->json($result, 200);
            }

            return response()->json($result, 500);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error in sendDisasterNotification: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
}