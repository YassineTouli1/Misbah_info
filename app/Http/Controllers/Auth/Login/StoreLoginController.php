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

        // Valider les données de la requête
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'L\'email est requis.',
            'email.email' => 'L\'email doit être valide.',
            'password.required' => 'Le mot de passe est requis.',
        ]);

        // Tenter l'authentification
        $credentials = $request->only('email', 'password');
        
        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            Log::warning('Échec de l\'authentification', ['email' => $request->email]);
            
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Ces identifiants ne correspondent pas à nos enregistrements.',
                ]);
        }

        // Régénérer la session pour prévenir les attaques de fixation de session
        $request->session()->regenerate();

        Log::info('Authentification réussie', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'user_role' => Auth::user()->role
        ]);

        // Rediriger en fonction du rôle de l'utilisateur
        if (Auth::user()->role === 'client') {
            Log::info('Redirection du client vers /client/home');
            return redirect('/client/home')
                ->with('success', 'Connexion réussie !');
        }

        // Pour les gérants et autres rôles
        Log::info('Redirection du gérant vers /dashboard');
        return redirect('/dashboard')
            ->with('success', 'Connexion réussie !');
    }
}
