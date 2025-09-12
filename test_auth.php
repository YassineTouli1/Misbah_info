<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// Charger l'application Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Test d'authentification ===\n";

// Vérifier si l'utilisateur gérant existe
$gerant = \App\Models\User::where('email', 'gerant@snack.com')->first();

if ($gerant) {
    echo "✅ Utilisateur gérant trouvé:\n";
    echo "   ID: " . $gerant->id . "\n";
    echo "   Nom: " . $gerant->name . "\n";
    echo "   Email: " . $gerant->email . "\n";
    echo "   Rôle: " . $gerant->role . "\n";
    
    // Tester l'authentification
    $credentials = [
        'email' => 'gerant@snack.com',
        'password' => 'password'
    ];
    
    if (Auth::attempt($credentials)) {
        echo "✅ Authentification réussie!\n";
        echo "   User ID: " . Auth::id() . "\n";
        echo "   User Role: " . Auth::user()->role . "\n";
        
        // Tester le middleware de rôle
        if (Auth::user()->role === 'gerant') {
            echo "✅ Rôle gérant confirmé!\n";
        } else {
            echo "❌ Problème avec le rôle!\n";
        }
        
        Auth::logout();
    } else {
        echo "❌ Échec de l'authentification!\n";
    }
} else {
    echo "❌ Utilisateur gérant non trouvé!\n";
}

echo "\n=== Test terminé ===\n"; 