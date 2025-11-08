<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    public function index()
    {
        return response()->json(AboutUs::first());
    }

    public function update(Request $request)
    {
        $aboutUs = AboutUs::first();

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'mission' => 'nullable|string',
            'vision' => 'nullable|string',
            'why_choose_us' => 'nullable|string',
        ]);

        $aboutUs->update($validated);

        return response()->json($aboutUs);
    }

    public function uploadImage(Request $request)
    {
        $aboutUs = AboutUs::first();

        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($aboutUs->image && Storage::disk('public')->exists($aboutUs->image)) {
            Storage::disk('public')->delete($aboutUs->image);
        }

        $imagePath = $request->file('image')->store('about-us', 'public');
        $aboutUs->image = $imagePath;
        $aboutUs->save();

        return response()->json($aboutUs);
    }
}