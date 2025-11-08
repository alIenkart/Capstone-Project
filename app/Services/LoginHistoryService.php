<?php

namespace App\Services;

use App\Models\LoginHistory;
use App\Models\User;
use Illuminate\Http\Request;

class LoginHistoryService
{
    public static function recordLogin(Request $request, User $user)
    {
        LoginHistory::create([
            'user_id' => $user->id,
            'email' => $user->email,
            'logged_in_at' => now(),
        ]);
    }
}