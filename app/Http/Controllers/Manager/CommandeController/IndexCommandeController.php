<?php

namespace App\Http\Controllers\Manager\CommandeController;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\Request;

class IndexCommandeController extends Controller
{
    public function __invoke()
    {
        $commandes = Commande::with(['client', 'user', 'menuItems'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('dashboard.Commande.commandes', compact('commandes'));
    }
}
