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
    public function index(Request $request)
    {
        $period = $request->query('period');
        $packages = $this->getPackageCounts($period);
        $bookings = $this->getBookingCounts($period);
        $payments = $this->getPaymentCounts($period);
        $destinations = $this->getDestinationCounts($period);
        $revenue = $this->getRevenue($period);
        $booking_overview = $this->getBookingOverview($period);

        return new AnalyticsResource([
            'packages' => $packages,
            'bookings' => $bookings,
            'payments' => $payments,
            'destinations' => $destinations,
            'revenue' => $revenue,
            'booking_overview' => $booking_overview,
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

    public function getPackageCounts($period): array
    {
        $query = Packages::query();
    
        $query = $this->applyPeriodFilter($query, $period);    
        
        $statusCounts = $query->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return [
            'active' => $statusCounts->get('active', 0),
            'inactive' => $statusCounts->get('inactive', 0),
        ];
    }

    public function getBookingCounts($period): array
    {
        $query = Booking::query();

        $query = $this->applyPeriodFilter($query, $period);    

        $statusCounts = $query->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return [
            'approved' => $statusCounts->get('Approved', 0),
            'rejected' => $statusCounts->get('Rejected', 0),
            'cancelled' => $statusCounts->get('Cancelled', 0),
            'pending' => $statusCounts->get('Pending', 0),

        ];
    }

    public function getPaymentCounts($period): array
    {
        $query = Payment::query();

        $query = $this->applyPeriodFilter($query, $period); 
        
        $statusCounts = $query->selectRaw("
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

    public function getDestinationCounts($period): array
    {
        $query = Payment::query()
            ->where('is_fully_paid', true)
            ->with('booking');

        $query = $this->applyPeriodFilter($query, $period); 
        
        $destinationCounts = $query->get()
            ->groupBy(fn($payment) => optional($payment->booking->package)->destination)
            ->map(fn($group) => $group->count())
            ->toArray();

        return $destinationCounts;
    }

    public function getRevenue($period): array
    {
        $query = Payment::query();

        $query = $this->applyPeriodFilter($query, $period); 

        $format = $period === 'Yearly' ? 'Y' : 'Y-m';
        $label = $period === 'Yearly' ? 'year' : 'month';
        
        $revenueData = $query->get()
            ->groupBy(fn($payment) => $payment->created_at->format($format))
            ->map(fn($group) => [
                $label => $group->first()->created_at->format($format),
                'total_revenue' => $group->sum(fn($payment) => optional($payment->booking)->original_amount ?? 0)
            ])
            ->values()
            ->toArray();

        \Log::info($revenueData);
    
        return $revenueData;
    }

    public function getBookingOverview($period): array
    {
        $query = Booking::query();

        $query = $this->applyPeriodFilter($query, $period);

        $bookings = $query->with([
            'package:id,package_name,capacity,available_slot',
            'payment:id,booking_id,is_fully_paid'
        ])
            ->get([
                'id',
                'customer_name',
                'tour_type',
                'start_date',
                'total_quantity',
                'package_id',
                'duration',
            ]);

        return $bookings
            ->groupBy('package_id')
            ->map(function ($packageGroup) {

                $first = $packageGroup->first();

                return [
                    'package' => [
                        'name' => $first->package->package_name ?? null,
                        'capacity' => $first->package->capacity ?? null,
                        'available_slot' => $first->package->available_slot ?? null,
                    ],

                    'types' => $packageGroup
                        ->groupBy('tour_type')
                        ->map(function ($typeGroup) {

                            return $typeGroup
                                ->sortBy('start_date')
                                ->map(function ($booking) {
                                    return [
                                        'customer_name' => $booking->customer_name,
                                        'start_date' => $booking->start_date,
                                        'total_quantity' => $booking->total_quantity,
                                        'is_paid' => $booking->payment?->is_fully_paid ?? false,
                                        'duration' => $booking->duration,
                                    ];
                                });
                        })
                ];
            })
            ->sortBy(function ($packageGroup) {
                return collect($packageGroup['types'])
                    ->flatten(1)
                    ->min('start_date');
            })
            ->values()
            ->toArray();
    }
    
    /**
     * Apply period filter to a query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $period
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applyPeriodFilter($query, ?string $period)
    {
        if ($period === 'Monthly') {
            $query->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month);
        } elseif ($period === 'Yearly') {
            $query->whereYear('created_at', now()->year);
        }

        return $query;
    }
}
