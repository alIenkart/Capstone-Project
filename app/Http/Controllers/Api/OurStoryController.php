<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OurStory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OurStoryController extends Controller
{
    public function index()
    {
        return response()->json(OurStory::first());
    }

    public function update(Request $request)
    {
        $ourStory = OurStory::first();

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $ourStory->update($validated);

        return response()->json($ourStory);
    }

    public function uploadImage(Request $request)
    {
        $ourStory = OurStory::first();

        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($ourStory->image && Storage::disk('public')->exists($ourStory->image)) {
            Storage::disk('public')->delete($ourStory->image);
        }

        $imagePath = $request->file('image')->store('our-story', 'public');
        $ourStory->image = $imagePath;
        $ourStory->save();

        return response()->json($ourStory);
    }
}