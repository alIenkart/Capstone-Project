<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Packages;
use App\Models\Booking;
use App\Models\Payment;
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
        $payments = $this->getPaymentCounts();
        $destinations = $this->getDestinationCounts();
        $revenue = $this->getRevenue();

        return new AnalyticsResource([
            'packages' => $packages,
            'bookings' => $bookings,
            'payments' => $payments,
            'destinations' => $destinations,
            'revenue' => $revenue,
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

    public function getPaymentCounts(): array
    {
        $statusCounts = Payment::selectRaw("
                SUM(CASE WHEN is_fully_paid = 1 THEN 1 ELSE 0 END) AS fully_paid,
                SUM(CASE WHEN payment_status = 'Down Payment' AND is_fully_paid = 0 THEN 1 ELSE 0 END) AS down_payment,
                SUM(CASE WHEN payment_status = 'Under Review' THEN 1 ELSE 0 END) AS under_review
            ")
            ->first();
    
        return [
            'fully_paid'   => $statusCounts->fully_paid ?? 0,
            'down_payment' => $statusCounts->down_payment ?? 0,
            'under_review' => $statusCounts->under_review ?? 0,
        ];
    }

    public function getDestinationCounts(): array
    {
        $destinationCounts = Payment::query()
            ->where('is_fully_paid', true)
            ->with('booking')
            ->get()
            ->groupBy(fn($payment) => optional($payment->booking->package)->destination)
            ->map(fn($group) => $group->count())
            ->toArray();
    
        return $destinationCounts;
    }

    public function getRevenue(): array
    {
        $revenueData = Payment::with('booking')
        ->where('is_fully_paid', true)
        ->get()
        ->groupBy(fn($payment) => $payment->created_at->format('Y-m'))
        ->map(fn($group) => [
            'month' => $group->first()->created_at->format('Y-m'),
            'total_revenue' => $group->sum(fn($payment) => optional($payment->booking)->original_amount ?? 0)
        ])
        ->values()
        ->toArray();
    
        return $revenueData;
    }
    
    
    
}
