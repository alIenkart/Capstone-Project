<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Packages;
use App\Models\Booking;
use App\Http\Resources\AnalyticsResource;

class AnalyticsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = $this->getPackageCounts();
        $bookings = $this->getBookingCounts();

        return new AnalyticsResource([
            'packages' => $packages,
            'bookings' => $bookings,
        ]);
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

    public function getPackageCounts(): array
    {
        $statusCounts = Packages::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return [
            'active' => $statusCounts->get('active', 0),
            'inactive' => $statusCounts->get('inactive', 0),
        ];
    }

    public function getBookingCounts(): array
    {
        $statusCounts = Booking::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return [
            'approved' => $statusCounts->get('Approved', 0),
            'rejected' => $statusCounts->get('Rejected', 0),
            'cancelled' => $statusCounts->get('Cancelled', 0),
            'pending' => $statusCounts->get('Pending', 0),

        ];
    }
}
