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
    $request->validate([
        'role' => 'required|in:Admin,Customer',
    ]);

    $user = User::findOrFail($id);
    $user->role = $request->role;
    $user->save();

    return response()->json(['message' => 'User role updated successfully.'], 200);
}
}