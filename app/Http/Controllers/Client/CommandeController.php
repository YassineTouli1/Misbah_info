<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\MenuItem;
use App\Models\Caisse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Client;

class CommandeController extends Controller
{
    /**
     * Créer une nouvelle instance du contrôleur
     */
    public function __construct()
    {
        // Si tu veux appliquer des middlewares, fais-le dans le route/web.php, ou utilise la bonne classe Controller de Laravel
        // $this->middleware('auth');
        // $this->middleware('role:client');
        // $this->authorizeResource(Commande::class, 'commande', [
        //     'except' => ['create', 'store'],
        // ]);
    }

    /**
     * Afficher la liste des commandes du client connecté
     */
    /**
     * Afficher la liste des commandes du client connecté
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $commandes = Commande::with(['menuItems', 'client.user'])
            ->where('client_id', Auth::user()->client->id)
            ->latest()
            ->paginate(10);
            
        return view('client.commandes.index', compact('commandes'));
    }
    
    /**
     * Afficher les détails d'une commande spécifique
     */
    /**
     * Afficher les détails d'une commande spécifique
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\View\View
     */
    public function show(Commande $commande)
    {
        $this->authorize('view', $commande);
        
        // Charger les relations nécessaires
        $commande->load([
            'menuItems' => function($query) {
                $query->withTrashed(); // Inclure les articles supprimés
            },
            'client.user',
            'user' // Le gérant qui a traité la commande
        ]);
        
        return view('client.commandes.show', compact('commande'));
    }
    
    /**
     * Afficher le formulaire de création d'une commande
     */
    /**
     * Afficher le formulaire de création d'une commande
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', Commande::class);
        
        // Récupérer tous les articles
        $menuItems = MenuItem::orderBy('name')
            ->get();
            
        return view('client.commandes.create', compact('menuItems'));
    }
    
    /**
     * Enregistrer une nouvelle commande
     */
    /**
     * Enregistrer une nouvelle commande
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', Commande::class);
        
        // Valider les données de la requête
        $validated = $request->validate([
            'menu_items' => 'required|array|min:1',
            'menu_items.*.id' => 'required|exists:menu_items,id',
            'menu_items.*.quantity' => 'required|integer|min:1|max:20',
            'notes' => 'nullable|string|max:1000',
        ], [
            'menu_items.required' => 'Veuillez sélectionner au moins un article pour votre commande.',
            'menu_items.*.quantity.min' => 'La quantité doit être d\'au moins 1.',
            'menu_items.*.quantity.max' => 'La quantité ne peut pas dépasser 20 pour un même article.',
        ]);
        
        try {
            DB::beginTransaction();
            
            // Calculer le total
            $total = 0;
            $menuItems = [];
            
            foreach ($validated['menu_items'] as $item) {
                $menuItem = MenuItem::findOrFail($item['id']);
                $quantity = $item['quantity'];
                $menuItems[$menuItem->id] = [
                    'quantity' => $quantity,
                    'price' => $menuItem->prix,
                ];
                $total += $menuItem->prix * $quantity;
            }
            
            // Créer la commande
            $commande = new Commande([
                'client_id' => Auth::user()->client->id,
                'user_id' => 1, // ID du gérant par défaut
                'total' => $total,
                'statut' => Commande::STATUS_PENDING,
                'notes' => $validated['notes'] ?? null,
                'is_paid' => false,
            ]);
            
            $commande->save();
            
            // Attacher les articles du menu
            $commande->menuItems()->attach($menuItems);
            
            DB::commit();
            
            return redirect()
                ->route('client.commandes.show', $commande)
                ->with('success', 'Votre commande a été passée avec succès !');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la création de la commande', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la création de votre commande.');
        }
    }
    
    /**
     * Annuler une commande
     */
    /**
     * Annuler une commande
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\RedirectResponse
     */
    public function annuler(Commande $commande)
    {
        $this->authorize('cancel', $commande);
        
        // Vérifier si la commande peut être annulée
        if (!$commande->isEditable()) {
            return back()
                ->with('error', 'Cette commande ne peut plus être annulée car elle est déjà en cours de préparation ou a été traitée.');
        }
        
        try {
            DB::beginTransaction();
            
            // Mettre à jour le statut de la commande
            $commande->update([
                'statut' => Commande::STATUS_CANCELLED,
                'notes' => ($commande->notes ? $commande->notes . "\n\n" : '') . 
                          'Commande annulée par le client le ' . now()->format('d/m/Y H:i')
            ]);
            
            // Envoyer une notification au gérant
            // Notification::send(
            //     User::role('gerant')->get(),
            //     new CommandeAnnulee($commande)
            // );
            
            DB::commit();
            
            return redirect()
                ->route('client.commandes.show', $commande)
                ->with('success', 'Votre commande a été annulée avec succès.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de l\'annulation de la commande', [
                'commande_id' => $commande->id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->with('error', 'Une erreur est survenue lors de l\'annulation de la commande. Veuillez réessayer ou contacter le service client.');
        }
    }



    /**
     * Valider une commande livrée (client satisfait)
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\JsonResponse
     */
    public function valider(Commande $commande)
    {
        // Vérifier que la commande appartient au client connecté et est livrée
        if ($commande->client_id !== Auth::user()->client->id || $commande->statut !== 'livree') {
            return response()->json(['success' => false, 'message' => 'Action non autorisée.']);
        }

        try {
            $commande->validee_par_client = true;
            $commande->save();
            return response()->json(['success' => true, 'message' => 'Commande validée avec succès.']);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la validation de la commande', [
                'commande_id' => $commande->id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['success' => false, 'message' => 'Une erreur est survenue lors de la validation de la commande.']);
        }
    }
}
