<?php

namespace App\Http\Controllers\Manager\CommandeController;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\JsonResponse;

class EnPreparationCommandeController extends Controller
{
    public function __invoke(Commande $commande): JsonResponse
    {
        if (in_array($commande->statut, [Commande::STATUS_PENDING, Commande::STATUS_CONFIRMED])) {
            $commande->update(['statut' => Commande::STATUS_PREPARATION]);
            return response()->json([
                'success' => true,
                'message' => 'Commande mise en préparation',
                'statut' => $commande->statut,
                'status_label' => $commande->status_label
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Impossible de mettre en préparation cette commande'
        ], 400);
    }
} 