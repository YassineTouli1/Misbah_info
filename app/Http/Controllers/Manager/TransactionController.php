<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Caisse;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer les filtres
        $type = $request->get('type');
        $dateDebut = $request->get('date_debut');
        $dateFin = $request->get('date_fin');
        $search = $request->get('search');

        // Construire la requête
        $query = Transaction::with(['user', 'commande.client.user'])
            ->orderBy('created_at', 'desc');

        // Filtrer par type
        if ($type && in_array($type, ['ajout', 'tirage', 'commande'])) {
            $query->where('type', $type);
        }

        // Filtrer par période
        if ($dateDebut) {
            $query->whereDate('created_at', '>=', $dateDebut);
        }
        if ($dateFin) {
            $query->whereDate('created_at', '<=', $dateFin);
        }

        // Recherche
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('reference', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('commande', function($commandeQuery) use ($search) {
                      $commandeQuery->where('id', 'like', "%{$search}%");
                  });
            });
        }

        // Paginer les résultats
        $transactions = $query->paginate(20);

        // Calculer les statistiques
        $stats = [
            'total_ajouts' => Transaction::ajouts()->sum('montant'),
            'total_tirages' => Transaction::tirages()->sum('montant'),
            'total_commandes' => Transaction::commandes()->sum('montant'),
            'solde_actuel' => Caisse::first() ? Caisse::first()->montant : 0,
            'nombre_transactions' => Transaction::count(),
        ];

        // Statistiques de la période sélectionnée
        if ($dateDebut || $dateFin) {
            $periodeQuery = Transaction::query();
            if ($dateDebut) $periodeQuery->whereDate('created_at', '>=', $dateDebut);
            if ($dateFin) $periodeQuery->whereDate('created_at', '<=', $dateFin);
            
            $stats['periode_ajouts'] = (clone $periodeQuery)->ajouts()->sum('montant');
            $stats['periode_tirages'] = (clone $periodeQuery)->tirages()->sum('montant');
            $stats['periode_commandes'] = (clone $periodeQuery)->commandes()->sum('montant');
        }

        return view('dashboard.transactions.index', compact(
            'transactions',
            'stats',
            'type',
            'dateDebut',
            'dateFin',
            'search'
        ));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['user', 'commande.menuItems', 'commande.client.user']);
        
        return view('dashboard.transactions.show', compact('transaction'));
    }

    public function export(Request $request)
    {
        // Logique d'export (CSV, Excel, etc.)
        // À implémenter selon les besoins
        return response()->json(['message' => 'Export à implémenter']);
    }
}
