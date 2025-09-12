<?php

namespace App\Http\Controllers\Manager\CommandeController;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LivrerCommandeController extends Controller
{
    public function __invoke(Commande $commande): JsonResponse
    {
        if ($commande->canBeMarkedAsDelivered()) {
            try {
                $result = $commande->markAsDelivered();
                
                if ($result) {
                    // Créer une transaction de livraison (journalisation uniquement)
                    Transaction::createLivraisonTransaction($commande, Auth::id());
                    
                    return response()->json([
                        'success' => true,
                        'message' => 'Commande livrée et montant ajouté à la caisse',
                        'statut' => $commande->statut,
                        'status_label' => $commande->status_label
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la livraison: ' . $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Impossible de livrer cette commande'
        ], 400);
    }
} 