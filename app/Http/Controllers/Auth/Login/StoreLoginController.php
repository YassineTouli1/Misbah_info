<?php

namespace App\Http\Controllers\Auth\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

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

        // Find user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withInput($request->only('email'))
                         ->withErrors(['email' => 'Utilisateur non trouvé.']);
        }

        // If role is gerant, manually check password
        if ($user->role === 'gerant') {
            if (Hash::check($request->password, $user->password)) {
                Auth::login($user, $request->boolean('remember'));
                $request->session()->regenerate();

                Log::info('Authentification réussie (gerant)', [
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'user_role' => $user->role
                ]);

                return redirect()->route('dashboard')
                                 ->with('success', 'Connexion réussie en tant que Gérant !');
            } else {
                return back()->withInput($request->only('email'))
                             ->withErrors(['email' => 'Mot de passe incorrect.']);
            }
        }

        // Normal login for clients
        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            Log::warning('Échec de l\'authentification', ['email' => $request->email]);
            return back()->withInput($request->only('email'))
                         ->withErrors(['email' => 'Ces identifiants ne correspondent pas à nos enregistrements.']);
        }

        $request->session()->regenerate();

        Log::info('Authentification réussie (client)', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'user_role' => Auth::user()->role
        ]);

        return redirect()->route('client.home')->with('success', 'Connexion réussie !');
    }
}
