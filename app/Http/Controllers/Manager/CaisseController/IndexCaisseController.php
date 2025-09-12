<?php

namespace App\Http\Controllers\Manager\CaisseController;

use App\Http\Controllers\Controller;
use App\Models\Caisse;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexCaisseController extends Controller
{
    public function __invoke(Request $request)
    {
        // Récupérer le solde total de la caisse
        $soldeTotal = Caisse::getSoldeActuel();
        
        // Créer un objet caisse factice pour la vue (pour maintenir la compatibilité)
        $caisse = (object) ['montant' => $soldeTotal];
        
        // Récupérer les transactions avec filtres
        $query = Transaction::with(['user', 'commande.client.user'])
            ->orderBy('created_at', 'desc');
        
        // Filtres
        $type = $request->get('type');
        $dateDebut = $request->get('date_debut');
        $dateFin = $request->get('date_fin');
        
        if ($type && $type !== 'tous') {
            $query->where('type', $type);
        }
        
        if ($dateDebut) {
            $query->whereDate('created_at', '>=', $dateDebut);
        }
        
        if ($dateFin) {
            $query->whereDate('created_at', '<=', $dateFin);
        }
        
        $transactions = $query->paginate(20);
        
        // Statistiques simplifiées - seulement ajouts et retours
        $totalAjouts = Transaction::ajouts()->sum('montant');
        $totalRetours = Transaction::tirages()->sum('montant');
        
        // Nombre de transactions
        $nombreAjouts = Transaction::ajouts()->count();
        $nombreRetours = Transaction::tirages()->count();
        
        return view('dashboard.Caisse.caisse', compact(
            'caisse',
            'transactions',
            'totalAjouts',
            'totalRetours',
            'nombreAjouts',
            'nombreRetours',
            'type',
            'dateDebut',
            'dateFin'
        ));
    }
}
