<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Commande;
use Illuminate\Auth\Access\Response;

class CommandePolicy
{
    /**
     * Déterminer si l'utilisateur peut voir n'importe quel modèle.
     */
    public function viewAny(User $user): bool
    {
        // Les gérants et les clients peuvent voir les commandes, mais avec des restrictions différentes
        return in_array($user->role, ['gerant', 'client']);
    }

    /**
     * Déterminer si l'utilisateur peut voir le modèle.
     */
    public function view(User $user, Commande $commande): bool
    {
        // Un gérant peut voir toutes les commandes
        if ($user->role === 'gerant') {
            return true;
        }
        
        // Un client ne peut voir que ses propres commandes
        if ($user->role === 'client' && $user->client) {
            return $user->client->id === $commande->client_id;
        }
        
        return false;
    }

    /**
     * Déterminer si l'utilisateur peut créer des modèles.
     */
    public function create(User $user): bool
    {
        // Seuls les clients authentifiés peuvent créer des commandes
        return $user->role === 'client' && $user->client !== null;
    }

    /**
     * Déterminer si l'utilisateur peut mettre à jour le statut d'une commande.
     */
    public function updateStatus(User $user, Commande $commande): bool
    {
        // Seul un gérant peut changer le statut d'une commande
        return $user->role === 'gerant';
    }

    /**
     * Déterminer si l'utilisateur peut mettre à jour le modèle.
     */
    public function update(User $user, Commande $commande): bool
    {
        // Un gérant peut mettre à jour n'importe quelle commande
        if ($user->role === 'gerant') {
            return true;
        }
        
        // Un client peut mettre à jour sa commande uniquement si elle est en attente
        if ($user->role === 'client' && $user->client) {
            return $user->client->id === $commande->client_id && 
                   $commande->statut === Commande::STATUS_PENDING;
        }
        
        return false;
    }

    /**
     * Déterminer si l'utilisateur peut supprimer le modèle.
     */
    public function delete(User $user, Commande $commande): bool
    {
        // Seul un gérant peut supprimer une commande
        return $user->role === 'gerant';
    }
    
    /**
     * Déterminer si l'utilisateur peut annuler une commande.
     */
    public function cancel(User $user, Commande $commande): bool
    {
        // Un gérant peut annuler n'importe quelle commande annulable
        if ($user->role === 'gerant') {
            return in_array($commande->statut, [
                Commande::STATUS_PENDING,
                Commande::STATUS_CONFIRMED,
                Commande::STATUS_PREPARATION
            ]);
        }
        
        // Un client peut annuler sa commande si elle est en attente ou confirmée
        if ($user->role === 'client' && $user->client) {
            return $user->client->id === $commande->client_id && 
                   in_array($commande->statut, [
                       Commande::STATUS_PENDING, 
                       Commande::STATUS_CONFIRMED
                   ]);
        }
        
        return false;
    }
    
    /**
     * Déterminer si l'utilisateur peut mettre à jour le statut d'une commande.
     */
    public function updateStatus(User $user, Commande $commande): bool
    {
        // Seul un gérant peut mettre à jour le statut d'une commande
        return $user->role === 'gerant';
    }

    /**
     * Déterminer si l'utilisateur peut restaurer le modèle.
     */
    public function restore(User $user, Commande $commande): bool
    {
        return false;
    }

    /**
     * Déterminer si l'utilisateur peut supprimer définitivement le modèle.
     */
    public function forceDelete(User $user, Commande $commande): bool
    {
        return false;
    }
}
