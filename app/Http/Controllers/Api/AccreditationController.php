<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Accreditation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AccreditationController extends Controller
{
    public function index()
    {
        return response()->json(Accreditation::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $imagePath = $request->file('image')->store('accreditations', 'public');

        $accreditation = Accreditation::create([
            'image' => $imagePath,
        ]);

        return response()->json($accreditation, 201);
    }

    public function destroy($id)
    {
        $accreditation = Accreditation::findOrFail($id);

        if ($accreditation->image && Storage::disk('public')->exists($accreditation->image)) {
            Storage::disk('public')->delete($accreditation->image);
        }

        $accreditation->delete();

        return response()->json(['message' => 'Accreditation deleted']);
    }
}