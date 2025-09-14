<?php

namespace App\Http\Controllers\Auth\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StoreLoginController extends Controller
{
    public function __invoke(Request $request)
    {
        Log::info('Tentative de connexion', [
            'email' => $request->email,
            'ip' => $request->ip()
        ]);

        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'L\'email est requis.',
            'email.email' => 'L\'email doit être valide.',
            'password.required' => 'Le mot de passe est requis.',
        ]);

        // Attempt login
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            Log::warning('Échec de l\'authentification', ['email' => $request->email]);
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Ces identifiants ne correspondent pas à nos enregistrements.',
                ]);
        }

        // Regenerate session
        $request->session()->regenerate();

        Log::info('Authentification réussie', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'user_role' => Auth::user()->role
        ]);

        // Redirect based on role
        if (Auth::user()->role === 'client') {
            return redirect()->route('client.home')
                             ->with('success', 'Connexion réussie !');
        } elseif (Auth::user()->role === 'gerant') {
            return redirect()->route('dashboard')
                             ->with('success', 'Connexion réussie !');
        }

        // Default fallback
        return redirect('/')->with('error', 'Rôle inconnu.');
    }
}
