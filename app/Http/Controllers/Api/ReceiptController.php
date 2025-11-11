<?php

namespace App\Http\Controllers\Api;

use App\Models\Receipt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReceiptResource;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $receipt = Receipt::with(['payment', 'booking.package'])
            ->where('booking_id', $id)
            ->first();

        return new ReceiptResource($receipt);
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
