<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::all();
        return response()->json($bookings);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'customer_name' => 'required|string|max:255',
            'discount_id' => 'nullable',
            'voucher_id' => 'nullable|',
            'total_quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
        ]);

        $booking = Booking::create($validated);

        return response()->json([
            'message' => 'Booking created successfully.',
            'data' => $booking
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pending,Approved,Rejected',
            'id_type' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update($validated);

        if ($validated['status'] === 'Approved') {
            Payment::createFromBooking($booking);
        }

        return response()->json([
            'message' => 'Booking updated successfully.',
            'data' => $booking
        ]);
    }
}