<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Client;
use App\Models\MenuItem;
use App\Models\Caisse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\User;

class OrderController extends Controller
{
    /**
     * Créer une nouvelle instance du contrôleur
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:gerant');
        
        // Autoriser les méthodes avec les politiques correspondantes
        $this->authorizeResource(Commande::class, 'commande');
    }

    /**
     * Afficher la liste des commandes avec filtrage et recherche
     */
    public function index(Request $request)
    {
        $query = Commande::with(['client.user', 'menuItems', 'user'])
            ->latest();
            
        // Filtrage par statut
        if ($request->has('statut') && $request->statut !== 'tous') {
            $query->where('statut', $request->statut);
        }
        
        // Filtrage par date
        if ($request->has('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }
        
        if ($request->has('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }
        
        // Recherche par numéro de commande ou nom de client
        if ($request->has('recherche')) {
            $searchTerm = '%' . $request->recherche . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('id', 'like', $searchTerm)
                  ->orWhereHas('client.user', function($q) use ($searchTerm) {
                      $q->where('name', 'like', $searchTerm);
                  });
            });
        }
        
        $commandes = $query->paginate(15)->withQueryString();
        
        // Statistiques pour le tableau de bord
        $stats = [
            'aujourdhui' => Commande::whereDate('created_at', today())->count(),
            'en_attente' => Commande::where('statut', Commande::STATUS_PENDING)->count(),
            'en_cours' => Commande::whereIn('statut', [
                Commande::STATUS_CONFIRMED, 
                Commande::STATUS_PREPARATION
            ])->count(),
            'a_livrer' => Commande::where('statut', Commande::STATUS_READY)->count(),
        ];

        return view('manager.commandes.index', compact('commandes', 'stats'));
    }

    /**
     * Afficher les détails d'une commande
     */
    public function show(Commande $commande)
    {
        $this->authorize('view', $commande);
        
        // Charger les relations nécessaires avec les articles supprimés
        $commande->load([
            'client.user', 
            'user', // Le gérant qui a traité la commande
            'menuItems' => function($query) {
                $query->withTrashed();
            }
        ]);
        
        // Historique des statuts pour l'affichage
        $historique = [
            'Créée le' => $commande->created_at->format('d/m/Y H:i'),
            'Dernière mise à jour' => $commande->updated_at->format('d/m/Y H:i')
        ];
        
        if ($commande->date_livraison) {
            $historique['Livrée le'] = $commande->date_livraison->format('d/m/Y H:i');
        }
        
        // Prochain statut possible
        $prochainsStatuts = [];
        
        switch ($commande->statut) {
            case Commande::STATUS_PENDING:
                $prochainsStatuts[Commande::STATUS_CONFIRMED] = 'Confirmer la commande';
                $prochainsStatuts[Commande::STATUS_CANCELLED] = 'Annuler la commande';
                break;
                
            case Commande::STATUS_CONFIRMED:
                $prochainsStatuts[Commande::STATUS_PREPARATION] = 'Mettre en préparation';
                $prochainsStatuts[Commande::STATUS_CANCELLED] = 'Annuler la commande';
                break;
                
            case Commande::STATUS_PREPARATION:
                $prochainsStatuts[Commande::STATUS_READY] = 'Marquer comme prête';
                $prochainsStatuts[Commande::STATUS_CANCELLED] = 'Annuler la commande';
                break;
                
            case Commande::STATUS_READY:
                $prochainsStatuts[Commande::STATUS_DELIVERED] = 'Marquer comme livrée';
                break;
        }

        return view('manager.commandes.show', [
            'commande' => $commande,
            'historique' => $historique,
            'prochainsStatuts' => $prochainsStatuts
        ]);
    }

    /**
     * Mettre à jour le statut d'une commande
     */
    public function updateStatus(Request $request, Commande $commande)
    {
        $this->authorize('updateStatus', $commande);
        
        $request->validate([
            'statut' => 'required|in:' . implode(',', [
                Commande::STATUS_CONFIRMED,
                Commande::STATUS_PREPARATION,
                Commande::STATUS_READY,
                Commande::STATUS_DELIVERED,
                Commande::STATUS_CANCELLED,
                Commande::STATUS_RETURNED
            ]),
            'notes' => 'nullable|string|max:1000'
        ]);

        $statut = $request->input('statut');
        $notes = $request->input('notes');
        
        try {
            DB::beginTransaction();
            
            // Vérifier la transition de statut valide
            if (!$this->isValidStatusTransition($commande->statut, $statut)) {
                throw new \Exception('Transition de statut non autorisée');
            }
            
            // Mettre à jour le statut et les notes si fournies
            $updateData = ['statut' => $statut];
            
            if ($notes) {
                $updateData['notes'] = $commande->notes 
                    ? $commande->notes . "\n\n" . now()->format('d/m/Y H:i') . " - " . $notes
                    : $notes;
            }
            
            // Gérer les transitions spéciales
            switch ($statut) {
                case Commande::STATUS_DELIVERED:
                    $commande->markAsDelivered();
                    $message = 'Commande marquée comme livrée avec succès. Le montant a été ajouté à la caisse.';
                    break;
                    
                case Commande::STATUS_CANCELLED:
                    $updateData['annulee_par'] = Auth::id();
                    $updateData['date_annulation'] = now();
                    $commande->update($updateData);
                    $message = 'Commande annulée avec succès.';
                    break;
                    
                default:
                    $commande->update($updateData);
                    $message = 'Statut de la commande mis à jour avec succès.';
            }
            
            // Envoyer une notification au client si nécessaire
            // if (in_array($statut, [
            //     Commande::STATUS_CONFIRMED, 
            //     Commande::STATUS_READY,
            //     Commande::STATUS_DELIVERED
            // ])) {
            //     $commande->client->user->notify(new CommandeStatusUpdated($commande));
            // }
            
            DB::commit();
            
            return redirect()
                ->route('manager.commandes.show', $commande)
                ->with('success', $message);
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la mise à jour du statut de la commande', [
                'commande_id' => $commande->id,
                'user_id' => Auth::id(),
                'statut' => $statut ?? 'inconnu',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->with('error', 'Une erreur est survenue lors de la mise à jour du statut de la commande.')
                ->withInput();
        }
    }

    /**
     * Afficher le formulaire d'ajout d'une note
     */
    public function edit(Commande $commande)
    {
        $this->authorize('update', $commande);
        return view('manager.commandes.edit', compact('commande'));
    }

    /**
     * Mettre à jour les notes d'une commande
     */
    public function update(Request $request, Commande $commande)
    {
        $this->authorize('update', $commande);
        
        $validated = $request->validate([
            'notes' => 'nullable|string|max:1000'
        ]);

        $commande->update($validated);

        return redirect()->route('manager.commandes.show', $commande)
            ->with('success', 'Notes mises à jour avec succès.');
    }

    /**
     * Afficher les commandes par statut avec pagination
     */
    public function byStatus($status)
    {
        if (!in_array($status, [
            'en_attente', 'confirmee', 'en_preparation', 
            'prete', 'livree', 'annulee', 'retournee'
        ])) {
            abort(404);
        }
        
        // Libellés des statuts pour l'affichage
        $statutLabels = [
            'en_attente' => 'En attente',
            'confirmee' => 'Confirmée',
            'en_preparation' => 'En préparation',
            'prete' => 'Prête à être livrée',
            'livree' => 'Livrée',
            'annulee' => 'Annulée',
            'retournee' => 'Retournée'
        ];
        
        $query = Commande::where('statut', $status)
            ->with(['client.user', 'menuItems', 'user'])
            ->latest();
            
        // Si c'est la vue "à préparer", on peut trier par date de commande
        if ($status === 'confirmee' || $status === 'en_preparation') {
            $query->orderBy('created_at', 'asc');
        }
        
        $commandes = $query->paginate(15);
        
        // Statistiques pour le tableau de bord
        $stats = [
            'total' => Commande::count(),
            'en_attente' => Commande::where('statut', 'en_attente')->count(),
            'confirmee' => Commande::where('statut', 'confirmee')->count(),
            'en_preparation' => Commande::where('statut', 'en_preparation')->count(),
            'prete' => Commande::where('statut', 'prete')->count(),
            'livree' => Commande::where('statut', 'livree')->count(),
            'annulee' => Commande::where('statut', 'annulee')->count(),
            'retournee' => Commande::where('statut', 'retournee')->count(),
        ];

        return view('manager.commandes.by_status', [
            'commandes' => $commandes,
            'currentStatus' => $status,
            'statutLabel' => $statutLabels[$status] ?? ucfirst(str_replace('_', ' ', $status)),
            'stats' => $stats
        ]);
    }

    /**
     * Afficher les statistiques et rapports avancés
     */
    public function stats(Request $request)
    {
        // Période par défaut : 30 derniers jours
        $dateDebut = $request->input('date_debut', now()->subDays(30)->format('Y-m-d'));
        $dateFin = $request->input('date_fin', now()->format('Y-m-d'));
        
        // Validation des dates
        $request->validate([
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut'
        ]);
        
        // Conversion des dates
        $startDate = Carbon::parse($dateDebut)->startOfDay();
        $endDate = Carbon::parse($dateFin)->endOfDay();
        
        // Statistiques générales
        $stats = [
            'total_commandes' => Commande::whereBetween('created_at', [$startDate, $endDate])->count(),
            'chiffre_affaires' => Commande::where('statut', Commande::STATUS_DELIVERED)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('total'),
            'moyenne_panier' => Commande::where('statut', Commande::STATUS_DELIVERED)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->avg('total'),
            'commandes_livrees' => Commande::where('statut', Commande::STATUS_DELIVERED)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            'taux_conversion' => 0, // À calculer si nécessaire
        ];
        
        // Répartition par statut
        $repartitionStatuts = DB::table('commandes')
            ->select('statut', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('statut')
            ->pluck('total', 'statut')
            ->toArray();
        
        // Chiffre d'affaires par jour/semaine/mois
        $periode = $request->input('periode', 'jour');
        $format = $periode === 'mois' ? 'Y-m' : 'Y-m-d';
        
        $caParPeriode = Commande::select(
                DB::raw("DATE_FORMAT(created_at, '" . ($periode === 'mois' ? '%Y-%m' : '%Y-%m-%d') . "') as periode"),
                DB::raw('SUM(total) as total')
            )
            ->where('statut', Commande::STATUS_DELIVERED)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('periode')
            ->orderBy('periode')
            ->get();
        
        // Articles les plus vendus
        $topProduits = DB::table('commande_menu_item')
            ->join('menu_items', 'commande_menu_item.menu_item_id', '=', 'menu_items.id')
            ->join('commandes', 'commande_menu_item.commande_id', '=', 'commandes.id')
            ->select(
                'menu_items.nom',
                'menu_items.prix',
                DB::raw('SUM(commande_menu_item.quantity) as quantite'),
                DB::raw('SUM(commande_menu_item.quantity * commande_menu_item.price) as total')
            )
            ->whereBetween('commandes.created_at', [$startDate, $endDate])
            ->groupBy('menu_items.id', 'menu_items.nom', 'menu_items.prix')
            ->orderBy('quantite', 'desc')
            ->limit(10)
            ->get();
        
        return view('manager.commandes.stats', [
            'stats' => $stats,
            'repartitionStatuts' => $repartitionStatuts,
            'topProduits' => $topProduits,
            'caParPeriode' => $caParPeriode,
            'dateDebut' => $dateDebut,
            'dateFin' => $dateFin,
            'periode' => $periode
        ]);
    }

    /**
     * Vérifie si une transition de statut est valide
     */
    protected function isValidStatusTransition(string $currentStatus, string $newStatus): bool
    {
        $validTransitions = [
            Commande::STATUS_PENDING => [
                Commande::STATUS_CONFIRMED,
                Commande::STATUS_CANCELLED
            ],
            Commande::STATUS_CONFIRMED => [
                Commande::STATUS_PREPARATION,
                Commande::STATUS_CANCELLED
            ],
            Commande::STATUS_PREPARATION => [
                Commande::STATUS_READY,
                Commande::STATUS_CANCELLED
            ],
            Commande::STATUS_READY => [
                Commande::STATUS_DELIVERED
            ],
            // Une commande livrée peut être retournée
            Commande::STATUS_DELIVERED => [
                Commande::STATUS_RETURNED
            ],
            // Une commande annulée ou retournée ne peut pas changer de statut
            Commande::STATUS_CANCELLED => [],
            Commande::STATUS_RETURNED => []
        ];

        // Vérifier si la transition est autorisée
        return in_array($newStatus, $validTransitions[$currentStatus] ?? []);
    }
}
