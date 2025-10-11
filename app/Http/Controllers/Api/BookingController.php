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
            'voucher_id' => 'nullable|string',
            'total_quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'status' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:1000',
            'id_type' => 'nullable|string|max:255',
            'discount_id_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            
            // Package details
            'package_destination' => 'nullable|string|max:255',
            'tour_type' => 'nullable|string|max:255',
            'duration' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            
            // Pricing details
            'adults_quantity' => 'nullable|integer|min:0',
            'kids_quantity' => 'nullable|integer|min:0',
            'adult_rate' => 'nullable|numeric|min:0',
            'kids_rate' => 'nullable|numeric|min:0',
            'adult_total_amount' => 'nullable|numeric|min:0',
            'kids_total_amount' => 'nullable|numeric|min:0',
            'original_amount' => 'nullable|numeric|min:0',
            
            // Customer contact details
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:255',
            'customer_address' => 'nullable|string|max:500',
        ]);

        // Handle single discount ID image upload
        if ($request->hasFile('discount_id_image')) {
            $path = $request->file('discount_id_image')->store('discount_ids', 'public');
            $validated['discount_id_image'] = $path;
        }

        // Handle multiple discount images
        $discountImagePaths = [];
        if ($request->hasFile('discount_images')) {
            foreach ($request->file('discount_images') as $index => $file) {
                $path = $file->store('discount_ids', 'public');
                $discountImagePaths[] = $path;
            }
            $validated['discount_images'] = json_encode($discountImagePaths);
        }

        // Set default status if not provided
        if (!isset($validated['status'])) {
            $validated['status'] = 'Pending';
        }

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