<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InquirySubmitted;
use App\Models\Inquiry;

class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'destination' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:50',
            'adults' => 'nullable|integer|min:0',
            'children' => 'nullable|integer|min:0',
            'seniors' => 'nullable|integer|min:0',
            'subject' => 'nullable|string|max:255',
            'message' => 'nullable|string',
        ]);

        $inquiry = Inquiry::create($validated);

        // Send confirmation email to the customer and admin notification
        Mail::to($inquiry->email)
            ->cc(config('mail.from.address'))
            ->send(new InquirySubmitted($inquiry));

        return response()->json([
            'message' => 'Inquiry submitted successfully.',
            'data' => $inquiry
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
