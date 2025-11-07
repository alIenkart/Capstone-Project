<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TravelBlog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TravelBlogController extends Controller
{
    public function index()
    {
        return response()->json(TravelBlog::orderBy('date', 'desc')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'date' => 'required|date',
            'author' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('travel-blogs', 'public');
        }

        $blog = TravelBlog::create($validated);

        return response()->json($blog, 201);
    }

    public function show($id)
    {
        return response()->json(TravelBlog::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $blog = TravelBlog::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'date' => 'required|date',
            'author' => 'required|string|max:255',
        ]);

        $blog->update($validated);

        return response()->json($blog);
    }

    public function uploadImage(Request $request, $id)
    {
        $blog = TravelBlog::findOrFail($id);

        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        if ($blog->image && Storage::disk('public')->exists($blog->image)) {
            Storage::disk('public')->delete($blog->image);
        }

        $imagePath = $request->file('image')->store('travel-blogs', 'public');
        
        $blog->image = $imagePath;
        $blog->save();

        \Log::info('Image uploaded for travel blog ' . $id . ': ' . $imagePath);

        return response()->json($blog);
    }

    public function destroy($id)
    {
        $blog = TravelBlog::findOrFail($id);

        if ($blog->image && Storage::disk('public')->exists($blog->image)) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return response()->json(['message' => 'Travel blog deleted']);
    }
}