<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Packages;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PackagesController extends Controller
{
    /**
     * Display a listing of the packages.
     */
    public function index()
    {
        $packages = Packages::all();
        return response()->json(['data' => $packages], 200);
    }

    /**
     * Store a newly created package in storage.
     */
    public function store(Request $request)
    {
        \Log::info('=== STORE PACKAGE ===');
        \Log::info('Start Date from Request:', ['start_date' => $request->input('start_date')]);
        \Log::info('End Date from Request:', ['end_date' => $request->input('end_date')]);

        $itinerary = json_decode($request->input('itinerary'), true);
        $request->merge(['itinerary' => $itinerary]);

        $tour_classification = json_decode($request->input('tour_classification'), true);
        $request->merge(['tour_classification' => $tour_classification]);

        $validator = Validator::make($request->all(), [
            'package_name' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'region' => 'nullable|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
            'itinerary' => 'required|array',
            'itinerary.*' => 'required|string',
            'terms_condition' => 'required|string',
            'exclusions' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'available_slot' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
            'pax_rate' => 'required|numeric|min:0',
            'kids_pax_rate' => 'nullable|numeric|min:0',
            'discounted_rate' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tour_classification' => 'required|array',
            'tour_classification.*' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        try {
            $startDate = Carbon::createFromFormat('Y-m-d', $request->input('start_date'));
            $endDate = Carbon::createFromFormat('Y-m-d', $request->input('end_date'));
            
            \Log::info('Parsed Dates:', [
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
            ]);
            
            $duration = abs($endDate->diffInDays($startDate)) + 1;
            
            \Log::info('Duration Calculation:', [
                'start_date_timestamp' => $startDate->timestamp,
                'end_date_timestamp' => $endDate->timestamp,
                'diff_in_days' => abs($endDate->diffInDays($startDate)),
                'final_duration' => $duration,
            ]);

            $data['tour_duration'] = $duration;
        } catch (\Exception $e) {
            \Log::error('Date Parsing Error:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid date format'], 422);
        }

        $itinerary = $request->input('itinerary');
        $data['itinerary'] = json_encode($itinerary);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('packages', 'public');
            $data['image_path'] = $imagePath;
        } else {
            $data['image_path'] = 'default.jpg';
        }

        \Log::info('Data Before Create:', ['tour_duration' => $data['tour_duration']]);

        $package = Packages::create($data);

        \Log::info('Data After Create:', ['tour_duration' => $package->tour_duration]);

        return response()->json(['data' => $package, 'message' => 'Package created successfully'], 201);
    }

    /**
     * Display the specified package.
     */
    public function show($id)
    {
        $package = Packages::findOrFail($id);
        return response()->json(['data' => $package], 200);
    }

    /**
     * Update the specified package in storage.
     */
    public function update(Request $request, $id)
    {
        $package = Packages::findOrFail($id);

        \Log::info('=== UPDATE PACKAGE ===');
        \Log::info('Is Seasonal:', ['is_seasonal' => $package->is_seasonal]);

        $itinerary = json_decode($request->input('itinerary'), true);
        $request->merge(['itinerary' => $itinerary]);

        $tour_classification = $request->input('tour_classification', []);
        $request->merge(['tour_classification' => $tour_classification]);
        
        $validator = Validator::make($request->all(), [
            'package_name' => 'sometimes|required|string|max:255',
            'destination' => 'sometimes|required|string|max:255',
            'region' => 'sometimes|nullable|string|max:255',
            'description' => 'sometimes|required|string',
            'start_date' => 'sometimes|required|date_format:Y-m-d',
            'end_date' => 'sometimes|required|date_format:Y-m-d|after_or_equal:start_date',
            'itinerary' => 'required|array',
            'itinerary.*' => 'required|string',
            'terms_condition' => 'sometimes|required|string',
            'exclusions' => 'sometimes|required|string',
            'capacity' => 'sometimes|required|integer|min:1',
            'status' => 'sometimes|required|in:active,inactive',
            'pax_rate' => 'sometimes|nullable|numeric|min:0',
            'kids_pax_rate' => 'sometimes|nullable|numeric|min:0',
            'discounted_rate' => 'sometimes|required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tour_classification' => 'sometimes|array',
            'tour_classification.*' => 'sometimes|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        if ($request->has('start_date') && $request->has('end_date')) {
            try {
                $startDate = Carbon::createFromFormat('Y-m-d', $request->input('start_date'));
                $endDate = Carbon::createFromFormat('Y-m-d', $request->input('end_date'));
                
                $duration = abs($endDate->diffInDays($startDate)) + 1;
                
                $data['tour_duration'] = $duration;
            } catch (\Exception $e) {
                \Log::error('Date Parsing Error:', ['error' => $e->getMessage()]);
                return response()->json(['error' => 'Invalid date format'], 422);
            }
        }

        if ($request->hasFile('image')) {
            if ($package->image_path && $package->image_path !== 'default.jpg') {
                Storage::disk('public')->delete($package->image_path);
            }
            $image = $request->file('image');
            $imagePath = $image->store('packages', 'public');
            $data['image_path'] = $imagePath;
        }

        $total_booked = $package->capacity - $package->available_slot;

        if (isset($data['capacity'])) {
            $new_capacity = (int) $data['capacity'];
            $data['available_slot'] = max(0, $new_capacity - $total_booked);
        }

        if ($package->is_seasonal) {
            \Log::info('Package is seasonal, removing pricing from update');
            unset($data['pax_rate']);
            unset($data['kids_pax_rate']);
        }

        $package->update($data);

        return response()->json(['data' => $package, 'message' => 'Package updated successfully'], 200);
    }

    /**
     * Remove the specified package from storage.
     */
    public function destroy($id)
    {
        $package = Packages::findOrFail($id);
        
        if ($package->image_path) {
            Storage::disk('public')->delete($package->image_path);
        }
        
        $package->delete();

        return response()->json(['message' => 'Package deleted successfully'], 200);
    }

    public function toggleStatus($id)
    {
        $package = Packages::findOrFail($id);

        $package->status = $package->status === 'active' ? 'inactive' : 'active';
        $package->save();

        return response()->json([
            'data' => $package,
            'message' => 'Status updated successfully',
        ], 200);
    }

    public function updateSeasonalPricing(Request $request, $id)
    {
        $package = Packages::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'is_seasonal' => 'required|boolean',
            'seasonal_pax_rate' => 'required_if:is_seasonal,true|nullable|numeric|min:0',
            'seasonal_kids_pax_rate' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $package->update([
            'is_seasonal' => $request->is_seasonal,
            'seasonal_pax_rate' => $request->seasonal_pax_rate,
            'seasonal_kids_pax_rate' => $request->seasonal_kids_pax_rate,
        ]);

        return response()->json([
            'data' => $package,
            'message' => 'Seasonal pricing updated successfully'
        ], 200);
    }
    
    public function deactivateSeasonalPricing(Request $request, $id)
    {
        $package = Packages::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'is_seasonal' => 'required|boolean',
            'pax_rate' => 'required|numeric|min:0',
            'kids_pax_rate' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // When deactivating, restore original prices
        $package->update([
            'is_seasonal' => false,
            'pax_rate' => $request->pax_rate,
            'kids_pax_rate' => $request->kids_pax_rate,
            'seasonal_pax_rate' => null,
            'seasonal_kids_pax_rate' => null,
        ]);

        return response()->json([
            'data' => $package,
            'message' => 'Seasonal pricing deactivated successfully'
        ], 200);
    }
}