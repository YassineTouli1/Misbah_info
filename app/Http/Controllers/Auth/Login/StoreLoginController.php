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
            'ip' => $request->ip(),
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

        // Normalize email to lowercase
        $email = strtolower($request->email);

        // Find user by email (case insensitive)
        $user = User::whereRaw('LOWER(email) = ?', [$email])->first();

        // if (!$user) {
        //     return back()->withInput($request->only('email'))
        //                  ->withErrors(['email' => 'Utilisateur non trouvé.']);
        // }

        // Check password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withInput($request->only('email'))
                         ->withErrors(['email' => 'Mot de passe incorrect.']);
        }

        // Login the user
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        Log::info('Authentification réussie', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_role' => $user->role,
        ]);

        // Redirect based on role
        if ($user->role === 'gerant') {
            return redirect()->route('dashboard')
                             ->with('success', 'Connexion réussie en tant que Gérant !');
        } else {
            return redirect()->route('client.home')
                             ->with('success', 'Connexion réussie !');
        }
    }
}
