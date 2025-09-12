<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TestAuthController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        
        return response()->json([
            'is_authenticated' => Auth::check(),
            'user' => $user ? [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ] : null,
            'session_id' => $request->session()->getId(),
            'session_data' => $request->session()->all(),
        ]);
    }
} 