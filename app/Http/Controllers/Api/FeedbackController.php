<?php

namespace App\Http\Controllers\Api;

use App\Models\Feedback;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedback = Feedback::all();
        return response()->json($feedback);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'rate' => 'required|integer|min:1|max:5',
            'message' => 'nullable|string',
            'visibility' => 'required|boolean',
        ]);

        $feedback = Feedback::create($validatedData);

        return response()->json([
            'message' => 'Feedback created successfully',
            'data' => $feedback
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback)
    {
        return response()->json($feedback);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Feedback $feedback)
    {
        $validatedData = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'rate' => 'sometimes|integer|min:1|max:5',
            'message' => 'nullable|string',
            'visibility' => 'sometimes|boolean',
        ]);

        $feedback->update($validatedData);

        return response()->json([
            'message' => 'Feedback updated successfully',
            'data' => $feedback
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return response()->json(['message' => 'Feedback deleted successfully']);
    }
}
