<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Caisse extends Model
{
    use HasFactory;

    protected $table = 'caisses';

    protected $fillable = [
        'date',
        'montant',
        'notes'
    ];

    protected $casts = [
        'date' => 'date',
        'montant' => 'decimal:2'
    ];

    /**
     * Ajoute un montant à la caisse du jour
     * 
     * @param float $montant
     * @param string $notes
     * @return Caisse
     */
    public static function ajouterMontant(float $montant, string $notes = null): Caisse
    {
        return DB::transaction(function () use ($montant, $notes) {
            $today = now()->format('Y-m-d');

            // Vérifier si une entrée existe déjà pour aujourd'hui
            $caisse = self::whereDate('date', $today)->first();

            if ($caisse) {
                // Mise à jour du montant existant
                $caisse->increment('montant', $montant);

                if ($notes) {
                    $caisse->notes = ($caisse->notes ? $caisse->notes . "\n" : '') . $notes;
                    $caisse->save();
                }
            } else {
                // Création d'une nouvelle entrée
                $caisse = self::create([
                    'date' => $today,
                    'montant' => $montant,
                    'notes' => $notes
                ]);
            }

            return $caisse;
        });
    }

    /**
     * Récupère le solde actuel de la caisse
     * 
     * @return float
     */
    public static function getSoldeActuel(): float
    {
        return (float)self::sum('montant');
    }

    /**
     * Récupère le solde pour une date donnée
     * 
     * @param string $date au format Y-m-d
     * @return float
     */
    public static function getSoldePourDate(string $date): float
    {
        return (float)self::whereDate('date', $date)->sum('montant');
    }

    /**
     * Retire un montant de la caisse du jour (remboursement)
     * 
     * @param float $montant
     * @param string $notes
     * @return Caisse
     */
    public static function retirerMontant(float $montant, string $notes = null): Caisse
    {
        return DB::transaction(function () use ($montant, $notes) {
            $today = now()->format('Y-m-d');

            // Vérifier si une entrée existe déjà pour aujourd'hui
            $caisse = self::whereDate('date', $today)->first();

            if ($caisse) {
                // Retirer le montant (montant négatif)
                $caisse->increment('montant', -$montant);

                if ($notes) {
                    $caisse->notes = ($caisse->notes ? $caisse->notes . "\n" : '') . $notes;
                    $caisse->save();
                }
            } else {
                // Création d'une nouvelle entrée avec montant négatif
                $caisse = self::create([
                    'date' => $today,
                    'montant' => -$montant,
                    'notes' => $notes
                ]);
            }

            return $caisse;
        });
    }
}
