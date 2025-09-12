<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Commande;
use App\Models\Caisse;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        // Récupérer les utilisateurs et commandes existants
        $users = User::all();
        $commandes = Commande::all();
        
        if ($users->isEmpty()) {
            $this->command->warn('Aucun utilisateur trouvé. Création d\'un utilisateur de test.');
            $user = User::create([
                'name' => 'Manager Test',
                'email' => 'manager@test.com',
                'password' => bcrypt('password'),
                'role' => 'manager'
            ]);
            $users = collect([$user]);
        }

        // Créer des transactions d'ajout (ajouts manuels)
        for ($i = 0; $i < 15; $i++) {
            $montant = rand(50, 500);
            $user = $users->random();
            
            Transaction::createTransaction(
                Transaction::TYPE_AJOUT,
                $montant,
                "Ajout d'argent en caisse par " . $user->name,
                $user->id
            );
        }

        // Créer des transactions de tirage (tirages manuels)
        for ($i = 0; $i < 8; $i++) {
            $montant = rand(20, 200);
            $user = $users->random();
            
            Transaction::createTransaction(
                Transaction::TYPE_TIRAGE,
                $montant,
                "Tirage d'argent de la caisse par " . $user->name,
                $user->id
            );
        }

        // Créer des transactions de livraison (commandes livrées)
        if ($commandes->isNotEmpty()) {
            $commandesLivrees = $commandes->where('statut', 'livree');
            
            foreach ($commandesLivrees as $commande) {
                $user = $users->random();
                
                Transaction::createTransaction(
                    Transaction::TYPE_LIVRAISON,
                    $commande->total,
                    "Livraison commande #{$commande->id} - Client: {$commande->client->user->name}",
                    $user->id,
                    $commande->id
                );
            }
        } else {
            // Créer des transactions de livraison fictives
            for ($i = 0; $i < 12; $i++) {
                $montant = rand(30, 150);
                $user = $users->random();
                
                Transaction::createTransaction(
                    Transaction::TYPE_LIVRAISON,
                    $montant,
                    "Livraison commande #" . rand(100, 999) . " - Client: Client " . rand(1, 50),
                    $user->id
                );
            }
        }

        // Créer des transactions de retour (commandes retournées)
        if ($commandes->isNotEmpty()) {
            $commandesRetournees = $commandes->where('statut', 'retournee');
            
            foreach ($commandesRetournees as $commande) {
                $user = $users->random();
                
                Transaction::createTransaction(
                    Transaction::TYPE_RETOUR,
                    $commande->total,
                    "Retour commande #{$commande->id} - Client: {$commande->client->user->name}",
                    $user->id,
                    $commande->id
                );
            }
        } else {
            // Créer des transactions de retour fictives
            for ($i = 0; $i < 5; $i++) {
                $montant = rand(25, 100);
                $user = $users->random();
                
                Transaction::createTransaction(
                    Transaction::TYPE_RETOUR,
                    $montant,
                    "Retour commande #" . rand(100, 999) . " - Client: Client " . rand(1, 50),
                    $user->id
                );
            }
        }

        $this->command->info('Transactions créées avec succès !');
        $this->command->info('Total des transactions créées : ' . Transaction::count());
        
        // Afficher les statistiques
        $totalAjouts = Transaction::ajouts()->sum('montant');
        $totalTirages = Transaction::tirages()->sum('montant');
        $totalLivraisons = Transaction::livraisons()->sum('montant');
        $totalRetours = Transaction::retours()->sum('montant');
        
        $this->command->info("Statistiques des transactions :");
        $this->command->info("- Ajouts : " . number_format($totalAjouts, 2) . " DH");
        $this->command->info("- Tirages : " . number_format($totalTirages, 2) . " DH");
        $this->command->info("- Livraisons : " . number_format($totalLivraisons, 2) . " DH");
        $this->command->info("- Retours : " . number_format($totalRetours, 2) . " DH");
        
        // Afficher le solde final de la caisse
        $caisse = Caisse::first();
        if ($caisse) {
            $this->command->info("Solde final de la caisse : " . number_format($caisse->montant, 2) . " DH");
        }
    }
}
