<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Caisse;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'montant',
        'solde_avant',
        'solde_apres',
        'description',
        'user_id',
        'commande_id',
        'reference'
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'solde_avant' => 'decimal:2',
        'solde_apres' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Types de transactions
    const TYPE_AJOUT = 'ajout';
    const TYPE_TIRAGE = 'tirage';
    const TYPE_LIVRAISON = 'livraison';
    const TYPE_RETOUR = 'retour';

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    // Scopes pour filtrer les transactions
    public function scopeAjouts($query)
    {
        return $query->where('type', self::TYPE_AJOUT);
    }

    public function scopeTirages($query)
    {
        return $query->where('type', self::TYPE_TIRAGE);
    }

    public function scopeLivraisons($query)
    {
        return $query->where('type', self::TYPE_LIVRAISON);
    }

    public function scopeRetours($query)
    {
        return $query->where('type', self::TYPE_RETOUR);
    }

    public function scopeParPeriode($query, $debut, $fin)
    {
        return $query->whereBetween('created_at', [$debut, $fin]);
    }

    // Méthodes utilitaires
    public function getTypeLabelAttribute()
    {
        return match ($this->type) {
            self::TYPE_AJOUT => 'Ajout',
            self::TYPE_TIRAGE => 'Tirage',
            self::TYPE_LIVRAISON => 'Livraison',
            self::TYPE_RETOUR => 'Retour',
            default => 'Inconnu'
        };
    }

    public function getMontantFormattedAttribute()
    {
        return number_format($this->montant, 2) . ' DH';
    }

    public function getSoldeAvantFormattedAttribute()
    {
        return number_format($this->solde_avant, 2) . ' DH';
    }

    public function getSoldeApresFormattedAttribute()
    {
        return number_format($this->solde_apres, 2) . ' DH';
    }

    public function getDateFormattedAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    // Méthode pour générer une référence unique
    public static function generateReference()
    {
        return 'TXN-' . date('Ymd') . '-' . strtoupper(uniqid());
    }

    // Méthode pour créer une transaction (n'ajuste PAS la caisse)
    public static function createTransaction($type, $montant, $description, $userId, $commandeId = null)
    {
        try {
            // On utilise le solde réel actuel (déjà mis à jour ailleurs)
            $soldeCourant = Caisse::getSoldeActuel();

            // On reconstruit solde_avant en fonction du type et du fait que
            // la caisse a déjà été ajustée juste avant l'enregistrement de la transaction
            $soldeApres = $soldeCourant;
            $soldeAvant = match ($type) {
                self::TYPE_AJOUT, self::TYPE_LIVRAISON => $soldeCourant - $montant,
                self::TYPE_TIRAGE, self::TYPE_RETOUR => $soldeCourant + $montant,
                default => $soldeCourant
            };

            // Créer la transaction (journalisation uniquement)
            return self::create([
                'type' => $type,
                'montant' => $montant,
                'solde_avant' => $soldeAvant,
                'solde_apres' => $soldeApres,
                'description' => $description,
                'user_id' => $userId,
                'commande_id' => $commandeId,
                'reference' => self::generateReference()
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur Transaction::createTransaction : ' . $e->getMessage(), [
                'type' => $type,
                'montant' => $montant,
                'userId' => $userId,
                'commandeId' => $commandeId,
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    // Méthode pour créer une transaction de livraison (appelée automatiquement lors des livraisons)
    public static function createLivraisonTransaction($commande, $userId)
    {
        $description = "Livraison commande #{$commande->id} - Client: {$commande->client->user->name}";

        return self::createTransaction(
            self::TYPE_LIVRAISON,
            $commande->total,
            $description,
            $userId,
            $commande->id
        );
    }

    // Méthode pour créer une transaction de retour (appelée automatiquement lors des retours de commandes)
    public static function createRetourTransaction($commande, $userId)
    {
        $description = "Retour commande #{$commande->id} - Client: {$commande->client->user->name}";

        return self::createTransaction(
            self::TYPE_RETOUR,
            $commande->total,
            $description,
            $userId,
            $commande->id
        );
    }
}
