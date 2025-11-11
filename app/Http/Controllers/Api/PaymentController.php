<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PaymentResource;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('booking:id,id,customer_name')->get();

        return response()->json($payments);
    }

    public function show($id){
        $payment = Payment::with('booking')->find($id);

        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        return new PaymentResource($payment);
    }

    // Modified to accept booking_id instead of payment_id
    public function update(Request $request, $id)
    {
        $request->validate([
            'proof_of_payment' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'payment_history' => 'nullable|json',
            'payment_status' => 'nullable|string',
            'mode_of_payment' => 'nullable|string',
            'total_price' => 'nullable|numeric',
            'is_fully_paid' => 'nullable|boolean',
            'type_of_payment' => 'nullable|string',
            'remarks' => 'nullable|string',
            'rejection_category' => 'nullable|string|required_if:payment_status,Rejected',
            'rejection_reason' => 'nullable|string|required_if:payment_status,Rejected',
        ]);

        if ($request->input('type') === 'payment_submission') {
            $payment = Payment::firstOrCreate(
                ['booking_id' => $id],
                [
                    'payment_status' => 'Pending',
                    'total_price' => 0,
                ]
            );
        } else {
            $payment = Payment::where('id', $id)->first();
    
            if (!$payment) {
                return response()->json([
                    'message' => 'Payment not found.',
                ], 404);
            }
        }  

        if ($request->hasFile('proof_of_payment')) {
            $filePath = $request->file('proof_of_payment')->store('receipt', 'public');

            $existingProofs = $payment->proof_of_payment ? json_decode($payment->proof_of_payment, true) : [];
            $existingProofs[] = $filePath;

            $payment->proof_of_payment = json_encode($existingProofs);
        }

        if ($request->has('payment_history')) {
            $newHistory = json_decode($request->payment_history, true);

            $existingHistory = $payment->payment_history 
                ? $payment->payment_history 
                : [];

            if (!is_array($existingHistory)) $existingHistory = [];

            $existingHistory[] = $newHistory;

            $payment->payment_history = $existingHistory;
        }

        if ($request->has('payment_status')) {
            $payment->payment_status = $request->payment_status;
        }

        if ($request->has('mode_of_payment')) {
            $payment->mode_of_payment = $request->mode_of_payment;
        }

        if ($request->has('remarks')) {
            $payment->remarks = $request->remarks;
        }

        if ($request->has('total_price')) {
            $payment->total_price = $request->total_price;
        }

        if ($request->has('is_fully_paid')) {
            $payment->is_fully_paid = $request->is_fully_paid;
        
            if ($request->is_fully_paid) {
                $payment->payment_status = 'Approved';
                $response = $this->processPackageSlotUpdate($payment);
            
                if ($response instanceof \Illuminate\Http\JsonResponse) {
                    return $response;
                }
                $user = Auth::user();
                Receipt::createReceipt($payment, $user->id);
            }
        }

        if ($request->has('type_of_payment')) {
            $payment->type_of_payment = $request->type_of_payment;
        }

        if ($request->payment_status === 'Rejected') {
            $payment->is_fully_paid = false;
            $payment->rejection_category = $request->rejection_category;
            $payment->rejection_reason = $request->rejection_reason;
            $payment->rejected_at = now();
        }

        $payment->save();

        return response()->json([
            'message' => 'Payment updated successfully',
            'payment' => $payment
        ]);
    }

    private function processPackageSlotUpdate(Payment $payment)
    {
        $booking = $payment->booking;
        $package = $booking->package;

        $total_quantity = $booking->total_quantity;
        $available_slot = $package->available_slot;

        if ($total_quantity > $available_slot) {
            return response()->json([
                'message' => 'Transaction cancelled. Total quantity exceeds available slots.',
                'errors' => [
                    'total_quantity' => "The booking quantity ({$total_quantity}) exceeds the available slots ({$available_slot})."
                ]
            ], 422);
        }

        $updated_slot = $available_slot - $total_quantity;
        $package->available_slot = $updated_slot;
        $package->save();

        return true;
    }
}
