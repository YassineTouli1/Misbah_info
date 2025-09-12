<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TestLoginController extends Controller
{
    public function __invoke(Request $request)
    {
        Log::info('Test login controller called', [
            'method' => $request->method(),
            'email' => $request->email ?? 'not provided',
            'has_password' => $request->has('password')
        ]);

        // Simuler une connexion réussie
        $user = \App\Models\User::where('email', 'gerant@snack.com')->first();
        
        if ($user) {
            Auth::login($user);
            
            Log::info('Test login successful', [
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->role
            ]);
            
            return redirect('/dashboard')->with('success', 'Test connexion réussie !');
        }
        
        return response()->json(['error' => 'User not found']);
    }
} 