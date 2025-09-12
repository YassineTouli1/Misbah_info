<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Support\Facades\Auth;

class ClientHomeController extends Controller
{
    public function index()
    {
        // Vérifier si l'utilisateur a un profil client
        if (!Auth::user()->client) {
            // Créer automatiquement un profil client
            $client = \App\Models\Client::create([
                'user_id' => Auth::id(),
                'phone' => 'Non renseigné'
            ]);
        } else {
            $client = Auth::user()->client;
        }
        
        // Récupérer seulement les commandes du client connecté
        $commandes = Commande::where('client_id', $client->id)
            ->with(['menuItems'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('client.home', compact('commandes'));
    }
}





