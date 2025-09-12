<?php

namespace App\Http\Controllers\Manager\CommandeController;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\JsonResponse;

class ConfirmerCommandeController extends Controller
{
    public function __invoke(Commande $commande): JsonResponse
    {
        if ($commande->statut === Commande::STATUS_PENDING) {
            $commande->update(['statut' => Commande::STATUS_CONFIRMED]);
            return response()->json([
                'success' => true,
                'message' => 'Commande confirmée avec succès',
                'statut' => $commande->statut,
                'status_label' => $commande->status_label
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Impossible de confirmer cette commande'
        ], 400);
    }
} 