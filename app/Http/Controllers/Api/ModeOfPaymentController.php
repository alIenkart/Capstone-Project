<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModeOfPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModeOfPaymentController extends Controller
{
    /**
     * Display all mode of payments
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => ModeOfPayment::orderBy('created_at', 'desc')->get(),
        ]);
    }

    /**
     * Store a new mode of payment
     */
    public function store(Request $request)
    {
        $request->validate([
            'mode_of_payment' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'qr_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = $request->user();
        $path = $request->file('qr_image')->store('mode_of_payments', 'public');

        $payment = ModeOfPayment::create([
            'mode_of_payment' => $request->mode_of_payment,
            'notes' => $request->notes,
            'created_by' => $user->first_name . ' ' . $user->last_name,
            'qr_image' => $path,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Mode of Payment created successfully.',
            'data' => $payment,
        ], 201);
    }

    /**
     * Display a single payment record
     */
    public function show($id)
    {
        $payment = ModeOfPayment::find($id);

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Record not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $payment,
        ]);
    }

    /**
     * Update a mode of payment
     */
    public function update(Request $request, $id)
    {
        $payment = ModeOfPayment::find($id);

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Record not found.',
            ], 404);
        }

        $request->validate([
            'mode_of_payment' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'qr_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('qr_image')) {
            $imagePath = $request->file('qr_image')->store('mode_of_payments', 'public');
            $payment->qr_image = $imagePath;
        }


        $payment->update([
            'mode_of_payment' => $request->mode_of_payment,
            'notes' => $request->notes,
            'qr_image' => $imagePath ?? $payment->qr_image,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Mode of Payment updated successfully.',
            'data' => $payment,
        ]);
    }

    /**
     * Delete a Mode of Payment
     */
    public function destroy($id)
    {
        $payment = ModeOfPayment::find($id);

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Record not found.',
            ], 404);
        }

        // Delete QR Image
        if ($payment->qr_image && Storage::disk('public')->exists($payment->qr_image)) {
            Storage::disk('public')->delete($payment->qr_image);
        }

        $payment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Mode of Payment deleted successfully.',
        ]);
    }
}
