<?php

namespace App\Http\Controllers;

use App\Models\LoginHistory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminLoginHistoryController extends Controller
{
    /**
     * Display login history with filters and pagination
     */
    public function index(Request $request)
    {
        try {
            $query = LoginHistory::query()->orderBy('logged_in_at', 'desc');

            // Filter by status if provided
            if ($request->has('status') && $request->status !== 'All') {
                $query->where('status', $request->status);
            }

            // Get paginated results
            $histories = $query->paginate(15);

            return Inertia::render('Admin/LoginHistory', [
                'histories' => $histories,
            ]);
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Login History Error: ' . $e->getMessage());

            // Return with empty data to prevent loading state
            return Inertia::render('Admin/LoginHistory', [
                'histories' => [
                    'data' => [],
                    'current_page' => 1,
                    'per_page' => 15,
                    'total' => 0,
                ],
            ]);
        }
    }
}