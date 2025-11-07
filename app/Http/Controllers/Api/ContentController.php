<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    public function index()
    {
        return response()->json(Content::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('contents', 'public');
        }

        $content = Content::create($validated);

        return response()->json($content, 201);
    }

    public function show($id)
    {
        return response()->json(Content::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $content = Content::findOrFail($id);

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $content->update($validated);

        return response()->json($content);
    }

    public function uploadImage(Request $request, $id)
    {
        $content = Content::findOrFail($id);

        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($content->image && Storage::disk('public')->exists($content->image)) {
            Storage::disk('public')->delete($content->image);
        }

        $imagePath = $request->file('image')->store('contents', 'public');
        
        $content->image = $imagePath;
        $content->save();

        \Log::info('Image uploaded for content ' . $id . ': ' . $imagePath);

        return response()->json($content);
    }

    public function destroy($id)
    {
        $content = Content::findOrFail($id);

        if ($content->title === 'INTRODUCTION') {
            return response()->json(['error' => 'Cannot delete the Introduction section'], 403);
        }

        if ($content->image && Storage::disk('public')->exists($content->image)) {
            Storage::disk('public')->delete($content->image);
        }

        $content->delete();

        return response()->json(['message' => 'Content deleted']);
    }
}