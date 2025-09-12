<?php

namespace Tests\Unit;

use App\Models\Commande;
use App\Models\MenuItem;
use App\Models\User;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommandeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function un_client_peut_creer_une_commande()
    {
        // Créer un client
        $user = User::factory()->create(['role' => 'client']);
        $client = Client::factory()->create(['user_id' => $user->id]);
        
        // Créer des articles de menu
        $menuItem1 = MenuItem::factory()->create(['prix' => 10.50]);
        $menuItem2 = MenuItem::factory()->create(['prix' => 15.75]);
        
        // Authentifier l'utilisateur
        $this->actingAs($user);
        
        // Données de la requête
        $data = [
            'menu_items' => [
                ['id' => $menuItem1->id, 'quantity' => 2],
                ['id' => $menuItem2->id, 'quantity' => 1]
            ],
            'notes' => 'Sans oignon s\'il vous plaît'
        ];
        
        // Soumettre le formulaire
        $response = $this->post(route('client.commandes.store'), $data);
        
        // Vérifier la réponse
        $response->assertRedirect(route('client.commandes.show', Commande::first()));
        $response->assertSessionHas('success');
        
        // Vérifier la base de données
        $this->assertDatabaseHas('commandes', [
            'client_id' => $client->id,
            'total' => 36.75, // (10.50 * 2) + 15.75
            'statut' => 'en_attente',
            'notes' => 'Sans oignon s\'il vous plaît'
        ]);
        
        // Vérifier les articles de la commande
        $commande = Commande::first();
        $this->assertCount(2, $commande->menuItems);
        $this->assertEquals(2, $commande->menuItems->find($menuItem1->id)->pivot->quantity);
        $this->assertEquals(1, $commande->menuItems->find($menuItem2->id)->pivot->quantity);
    }
    
    /** @test */
    public function un_gerant_peut_confirmer_une_commande()
    {
        // Créer un gérant
        $gerant = User::factory()->create(['role' => 'gerant']);
        
        // Créer une commande
        $commande = Commande::factory()->create(['statut' => 'en_attente']);
        
        // Authentifier le gérant
        $this->actingAs($gerant);
        
        // Mettre à jour le statut
        $response = $this->patch(route('manager.commandes.update-status', $commande), [
            'statut' => 'confirmee'
        ]);
        
        // Vérifier la réponse
        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        // Vérifier la base de données
        $this->assertDatabaseHas('commandes', [
            'id' => $commande->id,
            'statut' => 'confirmee'
        ]);
    }
    
    /** @test */
    public function la_livraison_met_a_jour_la_caisse()
    {
        // Créer un gérant
        $gerant = User::factory()->create(['role' => 'gerant']);
        
        // Créer une commande prête à être livrée
        $commande = Commande::factory()->create([
            'statut' => 'prete',
            'total' => 50.00,
            'is_paid' => false
        ]);
        
        // Authentifier le gérant
        $this->actingAs($gerant);
        
        // Marquer comme livrée
        $response = $this->patch(route('manager.commandes.update-status', $commande), [
            'statut' => 'livree'
        ]);
        
        // Vérifier la réponse
        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        // Vérifier la base de données
        $this->assertDatabaseHas('commandes', [
            'id' => $commande->id,
            'statut' => 'livree',
            'is_paid' => true,
            'date_livraison' => now()
        ]);
        
        // Vérifier la caisse
        $this->assertDatabaseHas('caisses', [
            'date' => now()->format('Y-m-d'),
            'montant' => 50.00
        ]);
    }
    
    /** @test */
    public function un_client_ne_peut_voir_que_ses_propres_commandes()
    {
        // Créer deux clients
        $client1 = Client::factory()->create(['user_id' => User::factory()->create(['role' => 'client'])->id]);
        $client2 = Client::factory()->create(['user_id' => User::factory()->create(['role' => 'client'])->id]);
        
        // Créer des commandes pour chaque client
        $commandeClient1 = Commande::factory()->create(['client_id' => $client1->id]);
        $commandeClient2 = Commande::factory()->create(['client_id' => $client2->id]);
        
        // Authentifier le premier client
        $this->actingAs($client1->user);
        
        // Vérifier que le client peut voir sa propre commande
        $response = $this->get(route('client.commandes.show', $commandeClient1));
        $response->assertOk();
        
        // Vérifier que le client ne peut pas voir la commande d'un autre client
        $response = $this->get(route('client.commandes.show', $commandeClient2));
        $response->assertForbidden();
    }
}
