<?php

namespace App\Http\Controllers\Manager\CaisseController;

use App\Http\Controllers\Controller;
use App\Models\Caisse;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddCaisseController extends Controller
{
    public function __invoke(Request $request)
    {
        $validate = $request->validate([
            'montant' => 'required|numeric|min:0.01',
        ]);

        $montant = $validate['montant'];

        try {
            DB::beginTransaction();
            
            // D'abord ajuster la caisse (source de vérité)
            Caisse::ajouterMontant(
                $montant, 
                "Ajout d'argent en caisse par " . Auth::user()->name
            );

            // Puis journaliser via le système de transactions unifié
            Transaction::createTransaction(
                Transaction::TYPE_AJOUT,
                $montant,
                "Ajout d'argent en caisse par " . Auth::user()->name,
                Auth::id()
            );

            DB::commit();
            
            return redirect()->route('manager.caisse')->with('success', 'Montant ajouté avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('manager.caisse')->with('error', 'Erreur lors de l\'ajout du montant: ' . $e->getMessage());
        }
    }
}
 
