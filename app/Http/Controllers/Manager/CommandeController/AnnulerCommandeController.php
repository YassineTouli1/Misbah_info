<?php

namespace App\Http\Controllers\Manager\CommandeController;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AnnulerCommandeController extends Controller
{
    public function __invoke(Request $request, Commande $commande): JsonResponse
    {
        $reason = $request->input('reason', 'Annulation par le gérant');
        
        if ($commande->canBeCancelled()) {
            $commande->cancel($reason);
            return response()->json([
                'success' => true,
                'message' => 'Commande annulée avec succès',
                'statut' => $commande->statut,
                'status_label' => $commande->status_label
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Impossible d\'annuler cette commande'
        ], 400);
    }
} 