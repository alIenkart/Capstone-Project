<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
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

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'proof_of_payment' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'payment_history' => 'nullable|json',
            'payment_status' => 'nullable|string',
            'mode_of_payment' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        if ($request->hasFile('proof_of_payment')) {
            $filePath = $request->file('proof_of_payment')->store('receipt', 'public');
            $payment->proof_of_payment = json_encode([$filePath]);
        }

        if ($request->has('payment_history')) {
            $paymentHistory = json_decode($request->payment_history, true);
            $payment->payment_history = $paymentHistory;
        }

        if ($request->has('payment_status')) {
            $payment->payment_status = $request->payment_status;
        }

        if ($request->has('mode_of_payment')) {
            $payment->mode_of_payment = json_decode($request->mode_of_payment, true);
        }

        if ($request->has('remarks')) {
            $payment->remarks = $request->remarks;
        }

        $payment->save();

        return response()->json([
            'message' => 'Payment updated successfully',
            'payment' => $payment
        ]);
    }
}