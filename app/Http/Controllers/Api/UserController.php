<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        return response()->json(['data' => $user], 200);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_number' => 'nullable|string|max:20',
            'role' => 'required|in:Admin,Customer',
        ]);

        $user = User::findOrFail($id);
        
        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->email = $validated['email'];
        $user->phone_number = $validated['phone_number'];
        $user->role = $validated['role'];
        
        // If email changed, reset email verification
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        
        $user->save();

        return response()->json([
            'message' => 'User updated successfully.',
            'data' => $user
        ], 200);
    }
}