<?php

namespace App\Http\Controllers\Client\CommandeController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\MenuItem;
use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StoreCommandeController extends Controller
{
    public function __invoke(Request $request)
    {
        // Debug: Log de début
        Log::info('StoreCommandeController appelé', [
            'user_id' => Auth::id(),
            'request_data' => $request->all(),
            'method' => $request->method(),
            'url' => $request->url()
        ]);

        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            Log::warning('Utilisateur non connecté tentant de passer une commande');
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour passer une commande.');
        }

        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'total' => 'required|numeric|min:0',
            'items' => 'required|string',
        ], [
            'user_id.required' => 'ID utilisateur requis.',
            'user_id.exists' => 'Utilisateur non trouvé.',
            'total.required' => 'Total requis.',
            'total.numeric' => 'Le total doit être un nombre.',
            'total.min' => 'Le total ne peut pas être négatif.',
            'items.required' => 'Articles requis.',
        ]);

        // Vérifier que l'utilisateur connecté correspond à l'user_id envoyé
        if (Auth::id() != $validated['user_id']) {
            Log::warning('Tentative de commande avec un user_id différent', [
                'auth_id' => Auth::id(),
                'requested_user_id' => $validated['user_id']
            ]);
            return back()->withErrors(['error' => 'Action non autorisée.']);
        }

        // Vérifier que l'utilisateur a le rôle client
        if (Auth::user()->role !== 'client') {
            Log::warning('Tentative de commande par un non-client', [
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->role
            ]);
            return back()->withErrors(['error' => 'Seuls les clients peuvent passer des commandes.']);
        }

        // Récupérer le client associé à l'utilisateur
        $client = Client::where('user_id', $validated['user_id'])->first();
        
        if (!$client) {
            // Créer automatiquement un profil client
            try {
                $client = Client::create([
                    'user_id' => $validated['user_id'],
                    'phone' => 'Non renseigné'
                ]);
            } catch (\Exception $e) {
                return back()->withErrors(['error' => 'Erreur lors de la création du profil client. Veuillez contacter l\'administrateur.']);
            }
        }

        try {
            DB::beginTransaction();

            // Décoder les articles
            $items = json_decode($validated['items'], true);
            
            if (!is_array($items) || empty($items)) {
                throw new \Exception('Aucun article sélectionné.');
            }

            // Vérifier que tous les articles existent et sont disponibles
            $menuItems = [];
            $calculatedTotal = 0;
            
            foreach ($items as $item) {
                $menuItem = MenuItem::where('id', $item['id'])->first();
                
                if (!$menuItem) {
                    throw new \Exception('Article introuvable.');
                }
                
                $quantity = $item['quantity'] ?? 1;
                if ($quantity < 1 || $quantity > 20) {
                    throw new \Exception('Quantité invalide pour un article.');
                }
                
                $menuItems[$menuItem->id] = [
                    'quantity' => $quantity,
                    'price' => $menuItem->price,
                ];
                
                $calculatedTotal += $menuItem->price * $quantity;
            }

            // Vérifier que le total calculé correspond au total envoyé
            if (abs($calculatedTotal - $validated['total']) > 0.01) {
                throw new \Exception('Le total ne correspond pas aux articles sélectionnés.');
            }

            // Créer la commande
            $commande = Commande::create([
                'user_id' => 1, // ID du gérant par défaut
                'client_id' => $client->id,
                'statut' => Commande::STATUS_PENDING,
                'total' => $calculatedTotal,
                'is_paid' => false,
            ]);

            // Attacher les articles du menu
            $commande->menuItems()->attach($menuItems);

            DB::commit();

            // Retourner une réponse JSON pour la popup
            return response()->json([
                'success' => true,
                'message' => 'Votre commande a été passée avec succès !',
                'commande_id' => $commande->id,
                'total' => $calculatedTotal
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Erreur lors de la création de la commande', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la création de votre commande : ' . $e->getMessage()
            ], 422);
        }
    }
}
