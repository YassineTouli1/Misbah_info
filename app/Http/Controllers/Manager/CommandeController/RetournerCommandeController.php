<?php

namespace App\Http\Controllers\Manager\CommandeController;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class RetournerCommandeController extends Controller
{
    public function __invoke(Request $request, Commande $commande): JsonResponse
    {
        // Vérifier que la commande est bien livrée
        if ($commande->statut !== Commande::STATUS_DELIVERED) {
            return response()->json([
                'success' => false,
                'message' => 'Seules les commandes livrées peuvent être retournées'
            ], 400);
        }

        try {
            $result = $commande->return($request->input('reason', 'Retour client - Client non satisfait'));
            
            if ($result) {
                // Créer une transaction de retour (journalisation uniquement)
                Transaction::createRetourTransaction($commande, Auth::id());
                
                return response()->json([
                    'success' => true,
                    'message' => 'Commande retournée avec succès. Le montant a été retiré de la caisse.',
                    'statut' => $commande->statut,
                    'status_label' => $commande->status_label
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Impossible de retourner cette commande'
                ], 400);
            }
        } catch (\Exception $e) {
            \Log::error('Erreur lors du retour de la commande', [
                'commande_id' => $commande->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors du retour de la commande'
            ], 500);
        }
    }
} 