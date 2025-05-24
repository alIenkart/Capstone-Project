<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Packages;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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
        $validator = Validator::make($request->all(), [
            'package_name' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'description' => 'required|string',
            'tour_duration' => 'required|string|max:255',
            'image_path' => 'required|string|max:2048',
            'itinerary' => 'required|string',
            'terms_condition' => 'required|string',
            'exclusions' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'joint_booking' => 'required|boolean',
            'status' => 'required|in:active,inactive',
            'pax_rate' => 'required|numeric|min:0',
            'discounted_rate' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        // Set a default image path if none is provided
        if (!isset($data['image_path'])) {
            $data['image_path'] = 'default.jpg';  // or any default image path you want
        }

        $package = Packages::create($data);

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

        $validator = Validator::make($request->all(), [
            'package_name' => 'sometimes|required|string|max:255',
            'destination' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'tour_duration' => 'sometimes|required|string|max:255',
            'image_path' => 'sometimes|required|string|max:2048',
            'itinerary' => 'sometimes|required|string',
            'terms_condition' => 'sometimes|required|string',
            'exclusions' => 'sometimes|required|string',
            'capacity' => 'sometimes|required|integer|min:1',
            'joint_booking' => 'sometimes|required|boolean',
            'status' => 'sometimes|required|in:active,inactive',
            'pax_rate' => 'sometimes|required|numeric|min:0',
            'discounted_rate' => 'sometimes|required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        if ($request->hasFile('image_path')) {
            // Delete old image if exists
            if ($package->image_path) {
                Storage::disk('public')->delete($package->image_path);
            }
            
            $image = $request->file('image_path');
            $imagePath = $image->store('packages', 'public');
            $data['image_path'] = $imagePath;
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
        
        // Delete image if exists
        if ($package->image_path) {
            Storage::disk('public')->delete($package->image_path);
        }
        
        $package->delete();

        return response()->json(['message' => 'Package deleted successfully'], 200);
    }
}
