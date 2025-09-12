<?php

namespace App\Http\Controllers\Manager\CaisseController;

use App\Http\Controllers\Controller;
use App\Models\Caisse;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TirerCaisseController extends Controller
{
    public function __invoke(Request $request)
    {
        $validate = $request->validate([
            'montant' => 'required|numeric|min:0.01',
        ]);

        $montant = $validate['montant'];

        try {
            // Vérifier le solde actuel
            $soldeActuel = Caisse::getSoldeActuel();
            
            if ($soldeActuel < $montant) {
                return redirect()->route('manager.caisse')->with('error', 'Le montant demandé dépasse le solde actuel.');
            }

            DB::beginTransaction();
            
            // D'abord ajuster la caisse (source de vérité)
            Caisse::retirerMontant(
                $montant, 
                "Tirage d'argent de la caisse par " . Auth::user()->name
            );

            // Puis journaliser via le système de transactions unifié
            Transaction::createTransaction(
                Transaction::TYPE_TIRAGE,
                $montant,
                "Tirage d'argent de la caisse par " . Auth::user()->name,
                Auth::id()
            );

            DB::commit();

            return redirect()->route('manager.caisse')->with('success', 'Montant retiré avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('manager.caisse')->with('error', 'Erreur lors du tirage du montant: ' . $e->getMessage());
        }
    }
}
            
