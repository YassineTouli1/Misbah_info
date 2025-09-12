<?php

namespace App\Http\Controllers\Manager\CommandeController;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\JsonResponse;

class PreteCommandeController extends Controller
{
    public function __invoke(Commande $commande): JsonResponse
    {
        if (in_array($commande->statut, [Commande::STATUS_CONFIRMED, Commande::STATUS_PREPARATION])) {
            $commande->update(['statut' => Commande::STATUS_READY]);
            return response()->json([
                'success' => true,
                'message' => 'Commande marquée comme prête',
                'statut' => $commande->statut,
                'status_label' => $commande->status_label
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Impossible de marquer comme prête cette commande'
        ], 400);
    }
} 