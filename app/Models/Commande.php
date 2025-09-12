<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MenuItem;
use App\Models\Caisse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\Client;
use App\Models\User;

class Commande extends Model
{
    // Constantes pour les statuts de commande
    const STATUS_PENDING = 'en_attente';
    const STATUS_CONFIRMED = 'confirmee';
    const STATUS_PREPARATION = 'en_preparation';
    const STATUS_READY = 'prete';
    const STATUS_DELIVERED = 'livree';
    const STATUS_CANCELLED = 'annulee';
    const STATUS_RETURNED = 'retournee';

    protected $fillable = [
        'total',
        'statut',
        'user_id',
        'client_id',
        'notes',
        'date_livraison',
        'is_paid',
        'mode_paiement',
        'notes_annulation'
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'is_paid' => 'boolean',
        'date_livraison' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected $appends = [
        'status_label',
        'status_class',
        'formatted_total'
    ];

    /**
     * Relation avec l'utilisateur (gérant)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec le client
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relation avec les articles du menu commandés
     */
    public function menuItems()
    {
        return $this->belongsToMany(MenuItem::class, 'commande_menu_item', 'commande_id', 'menuItem_id')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    /**
     * Scope pour les commandes de l'utilisateur connecté
     */
    public function scopeForCurrentUser($query)
    {
        return $query->where('user_id', Auth::id());
    }

    /**
     * Marquer la commande comme livrée et mettre à jour la caisse
     */
    public function markAsDelivered()
    {
        if ($this->canBeMarkedAsDelivered()) {
            // Ajouter le montant à la caisse AVANT de marquer comme payé
            // Eviter le double ajout: la transaction se contente de journaliser
            $this->updateCaisse();

            // Mettre à jour le statut et la date de livraison
            $this->update([
                'statut' => self::STATUS_DELIVERED,
                'date_livraison' => now(),
                'is_paid' => true
            ]);

            return true;
        }

        return false;
    }

    /**
     * Vérifier si la commande peut être marquée comme livrée
     */
    public function canBeMarkedAsDelivered()
    {
        return in_array($this->statut, [self::STATUS_READY, self::STATUS_CONFIRMED, self::STATUS_PREPARATION]);
    }

    /**
     * Mettre à jour la caisse avec le montant de la commande
     */
    protected function updateCaisse()
    {
        try {
            // Vérifier si la table caisses existe
            if (!Schema::hasTable('caisses')) {
                \Log::warning('La table caisses n\'existe pas');
                return false;
            }

            // Utiliser la méthode ajouterMontant du modèle Caisse (source de vérité)
            Caisse::ajouterMontant(
                $this->total,
                'Paiement de la commande #' . $this->id . ' - ' . $this->total . '€'
            );

            return true;
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la mise à jour de la caisse: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Retirer le montant de la commande de la caisse (remboursement)
     */
    protected function retirerDeCaisse()
    {
        try {
            // Vérifier si la table caisses existe
            if (!Schema::hasTable('caisses')) {
                \Log::warning('La table caisses n\'existe pas');
                return false;
            }

            // Utiliser la méthode retirerMontant du modèle Caisse (source de vérité)
            Caisse::retirerMontant(
                $this->total,
                'Remboursement commande #' . $this->id . ' - ' . $this->total . '€ (retour client)'
            );

            return true;
        } catch (\Exception $e) {
            \Log::error('Erreur lors du retrait de la caisse: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Vérifier si l'utilisateur peut voir la commande
     */
    public function canBeViewedBy(User $user)
    {
        // Un gérant peut voir toutes les commandes
        if ($user->hasRole('gerant') || $user->isAdmin()) {
            return true;
        }

        // Un client ne peut voir que ses propres commandes
        if ($user->hasRole('client') && $user->client) {
            return $this->client_id === $user->client->id;
        }

        return false;
    }

    /**
     * Vérifier si la commande peut être annulée
     */
    public function canBeCancelled()
    {
        return in_array($this->statut, [
            self::STATUS_PENDING,
            self::STATUS_CONFIRMED,
            self::STATUS_PREPARATION
        ]);
    }

    /**
     * Annuler la commande
     */
    public function cancel($reason = null)
    {
        if ($this->canBeCancelled()) {
            $this->update([
                'statut' => self::STATUS_CANCELLED,
                'notes_annulation' => $reason
            ]);

            return true;
        }

        return false;
    }

    /**
     * Retourner une commande livrée (client non satisfait)
     */
    public function return($reason = null)
    {
        if ($this->statut === self::STATUS_DELIVERED) {
            // Retirer le montant de la caisse si la commande était payée
            if ($this->is_paid) {
                $this->retirerDeCaisse();
            }

            $this->update([
                'statut' => self::STATUS_RETURNED,
                'notes_annulation' => $reason,
                'is_paid' => false // Rembourser le client
            ]);

            return true;
        }

        return false;
    }

    /**
     * Obtenir le total formaté
     */
    public function getFormattedTotalAttribute()
    {
        return number_format($this->total, 2, ',', ' ') . ' €';
    }

    /**
     * Obtenir le libellé du statut
     */
    public function getStatusLabelAttribute()
    {
        $statuses = [
            self::STATUS_PENDING => 'En attente',
            self::STATUS_CONFIRMED => 'Confirmée',
            self::STATUS_PREPARATION => 'En préparation',
            self::STATUS_READY => 'Prête',
            self::STATUS_DELIVERED => 'Livrée',
            self::STATUS_CANCELLED => 'Annulée',
            self::STATUS_RETURNED => 'Retournée'
        ];

        return $statuses[$this->statut] ?? $this->statut;
    }

    /**
     * Obtenir la classe CSS pour le statut
     */
    public function getStatusClassAttribute()
    {
        $classes = [
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_CONFIRMED => 'bg-blue-100 text-blue-800',
            self::STATUS_PREPARATION => 'bg-indigo-100 text-indigo-800',
            self::STATUS_READY => 'bg-green-100 text-green-800',
            self::STATUS_DELIVERED => 'bg-green-100 text-green-800',
            self::STATUS_CANCELLED => 'bg-red-100 text-red-800',
            self::STATUS_RETURNED => 'bg-red-100 text-red-800'
        ];

        return $classes[$this->statut] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Vérifier si la commande peut être modifiée par le client
     */
    public function isEditable()
    {
        return in_array($this->statut, [
            self::STATUS_PENDING,
            self::STATUS_CONFIRMED
        ]);
    }
}
