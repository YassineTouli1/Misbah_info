<!DOCTYPE html>
<html lang="fr">
<x-head-dashboard/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
/* Forcer le centrage vertical de la modale Bootstrap */
.modal.show {
    display: flex !important;
    align-items: center;
    justify-content: center;
}
.modal-dialog {
    margin: 0 auto;
}
.orders-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 10px;
    font-size: 1.05rem;
}
.orders-table th, .orders-table td {
    background: #fff;
    padding: 14px 18px;
    vertical-align: middle;
    border: none;
}
.orders-table th {
    color: #ff6600;
    font-weight: 700;
    font-size: 1.08rem;
    background: #f8f9fa;
    border-bottom: 2px solid #eee;
}
.orders-table tr {
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    border-radius: 12px;
    transition: box-shadow 0.2s;
}
.orders-table tr:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.10);
}
.badge, .badge-status {
    border-radius: 8px;
    padding: 4px 12px;
    font-size: 0.98rem;
    font-weight: 600;
    display: inline-block;
}
.badge-en_attente { background: #fff3cd; color: #856404; }
.badge-confirmee { background: #d1e7dd; color: #0f5132; }
.badge-en_preparation { background: #cff4fc; color: #055160; }
.badge-prete { background: #e2e3e5; color: #41464b; }
.badge-livree { background: #cfe2ff; color: #084298; }
.badge-annulee, .badge-retournee { background: #f8d7da; color: #842029; }
.btn, .btn-sm {
    border-radius: 8px !important;
    padding: 7px 18px !important;
    font-size: 1rem !important;
    margin-bottom: 4px;
    transition: background 0.2s, color 0.2s;
}
.btn-outline, .btn-primary, .btn-info, .btn-success, .btn-warning, .btn-danger {
    border: 1.5px solid #ff6600;
    color: #ff6600;
    background: #fff;
}
.btn-primary { background: #ff6600 !important; color: #fff !important; border: none !important; }
.btn-info { background: #17a2b8 !important; color: #fff !important; border: none !important; }
.btn-success { background: #28a745 !important; color: #fff !important; border: none !important; }
.btn-warning { background: #ffc107 !important; color: #fff !important; border: none !important; }
.btn-danger { background: #dc3545 !important; color: #fff !important; border: none !important; }
.btn-outline:hover {
    background: #ff6600 !important;
    color: #fff !important;
}
.orders-table td strong {
    font-size: 1.15rem;
    color: #ff6600;
}
.orders-table .text-muted {
    color: #aaa;
}
.orders-table ul {
    margin: 0;
    padding-left: 18px;
}
.action-btn-group {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    align-items: center;
    justify-content: flex-start;
}
</style>
<body>
<!-- Navbar -->
<x-nav-manager></x-nav-manager>

<!-- Dashboard Container -->
<div class="dashboard-container">
    <!-- Sidebar -->
    <x-sideNav></x-sideNav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Gestion des Commandes</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <section class="orders-section">
            <div class="table-responsive">
                <table class="orders-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Articles commandés</th>
                        <th>Total</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($commandes as $commande)
                        <tr data-commande-id="{{ $commande->id }}">
                            <td>#{{ $commande->id }}</td>
                            <td>
                                <strong>{{ $commande->client->user->name ?? 'Client inconnu' }}</strong><br>
                                <small>{{ $commande->client->user->email ?? '' }}</small>
                            </td>
                            <td>
                                @if($commande->menuItems->count() > 0)
                                    <ul class="list-unstyled">
                                        @foreach($commande->menuItems as $item)
                                            <li>
                                                {{ $item->pivot->quantity }}x {{ $item->nom ?? $item->name }} <small class="text-muted">({{ number_format($item->pivot->price, 2) }}DH)</small>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted">Aucun article</span>
                                @endif
                                @if($commande->notes)
                                    <div class="mt-2">
                                        <small class="text-info"><strong>Notes:</strong> {{ $commande->notes }}</small>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ number_format($commande->total, 2) }}DH</strong>
                                @if($commande->is_paid)
                                    <br><span class="badge badge-success">Payé</span>
                                @else
                                    <br><span class="badge badge-warning">Non payé</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $commande->status_class }}">
                                    {{ $commande->status_label }}
                                </span>
                            </td>
                            <td>
                                {{ $commande->created_at->format('d/m/Y H:i') }}
                                @if($commande->date_livraison)
                                    <br><small class="text-success">Livré: {{ $commande->date_livraison->format('d/m/Y H:i') }}</small>
                                @endif
                            </td>
                            <td>
                                <div class="action-btn-group" role="group">
                                    @if($commande->validee_par_client)
                                        <span class="badge badge-success" style="background:#28a745; color:#fff;">Validée par client</span>
                                    @endif
                                    @if($commande->canBeCancelled())
                                        @if($commande->statut === 'en_attente')
                                            <button class="btn btn-sm btn-primary action-btn" 
                                                    data-action="confirmer" 
                                                    data-commande-id="{{ $commande->id }}">
                                                <i class="fas fa-check"></i> Confirmer
                                            </button>
                                            <button class="btn btn-sm btn-info action-btn" 
                                                    data-action="en-preparation" 
                                                    data-commande-id="{{ $commande->id }}">
                                                <i class="fas fa-utensils"></i> En préparation
                                            </button>
                                        @endif
                                        @if($commande->statut === 'confirmee')
                                            <button class="btn btn-sm btn-info action-btn" 
                                                    data-action="en-preparation" 
                                                    data-commande-id="{{ $commande->id }}">
                                                <i class="fas fa-utensils"></i> En préparation
                                            </button>
                                            <button class="btn btn-sm btn-success action-btn" 
                                                    data-action="prete" 
                                                    data-commande-id="{{ $commande->id }}">
                                                <i class="fas fa-check-double"></i> Prête
                                            </button>
                                            <button class="btn btn-sm btn-success action-btn" 
                                                    data-action="livrer" 
                                                    data-commande-id="{{ $commande->id }}">
                                                <i class="fas fa-truck"></i> Livrer
                                            </button>
                                        @endif
                                        @if($commande->statut === 'en_preparation')
                                            <button class="btn btn-sm btn-success action-btn" 
                                                    data-action="prete" 
                                                    data-commande-id="{{ $commande->id }}">
                                                <i class="fas fa-check-double"></i> Prête
                                            </button>
                                            <button class="btn btn-sm btn-success action-btn" 
                                                    data-action="livrer" 
                                                    data-commande-id="{{ $commande->id }}">
                                                <i class="fas fa-truck"></i> Livrer
                                            </button>
                                        @endif
                                        <button class="btn btn-sm btn-danger action-btn" 
                                                data-action="annuler" 
                                                data-commande-id="{{ $commande->id }}">
                                            <i class="fas fa-times"></i> Annuler
                                        </button>
                                    @endif
                                    @if($commande->statut === 'prete')
                                        <button class="btn btn-sm btn-success action-btn" 
                                                data-action="livrer" 
                                                data-commande-id="{{ $commande->id }}">
                                            <i class="fas fa-truck"></i> Livrer
                                        </button>
                                    @endif
                                    @if($commande->statut === 'livree')
                                        <button class="btn btn-sm btn-warning action-btn" 
                                                data-action="retourner" 
                                                data-commande-id="{{ $commande->id }}">
                                            <i class="fas fa-undo"></i> Retourner
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Aucune commande trouvée</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $commandes->links() }}
            </div>
        </section>
    </main>
</div>

<script>
console.log('JS commandes chargé');
let currentAction = null;
let currentCommandeId = null;

// Gestion des actions sur les commandes
// Quand on clique sur Annuler, on annule directement sans raison
    document.querySelectorAll('.action-btn').forEach(btn => {
        btn.addEventListener('click', function(event) {
            event.preventDefault();
            const action = this.dataset.action;
            const commandeId = this.dataset.commandeId;
            console.log('Click bouton action', action, commandeId);
            executeAction(action, commandeId); // Annule directement
        });
    });

    function executeAction(action, commandeId) {
        // Confirmation spéciale pour le retour
        // if (action === 'retourner') {
        //     if (!confirm('Êtes-vous sûr de vouloir retourner cette commande ? Le client sera remboursé et le montant sera retiré de la caisse.')) {
        //         return;
        //     }
        // }
        
        const url = `{{ route('commandes.annuler', ':id') }}`.replace(':id', commandeId);
        const method = 'PATCH';
        
        // Construire l'URL correcte selon l'action
        const actionUrls = {
            'confirmer': `{{ route('commandes.confirmer', ':id') }}`,
            'en-preparation': `{{ route('commandes.en-preparation', ':id') }}`,
            'prete': `{{ route('commandes.prete', ':id') }}`,
            'livrer': `{{ route('commandes.livrer', ':id') }}`,
            'annuler': `{{ route('commandes.annuler', ':id') }}`,
            'retourner': `{{ route('commandes.retourner', ':id') }}`
        };

        const finalUrl = actionUrls[action].replace(':id', commandeId);

        fetch(finalUrl, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: null // Pas de raison pour l'annulation directe
        })
        .then(response => response.json())
        .then(data => {
            console.log('Réponse AJAX:', data);
            if (data.success) {
                showAlert('success', data.message);
                updateCommandeRow(commandeId, data);
            } else {
                showAlert('error', data.message || 'Erreur lors de l\'annulation.');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showAlert('error', 'Une erreur technique est survenue (réseau ou serveur).');
        });
    }

    function updateCommandeRow(commandeId, data) {
        const row = document.querySelector(`tr[data-commande-id='${commandeId}']`);
        if (!row) return;
        // Met à jour le badge de statut
        const statutCell = row.querySelector('td:nth-child(5) .badge, td:nth-child(5) .badge-status');
        if (statutCell && data.status_label) {
            statutCell.textContent = data.status_label;
            // Optionnel : changer la classe CSS selon le statut
            statutCell.className = 'badge badge-' + (data.statut || '');
        }
        // Met à jour les boutons d'action
        const actionsCell = row.querySelector('td:last-child .action-btn-group');
        if (actionsCell) {
            let html = '';
            // Générer les boutons selon le nouveau statut
            if (data.statut === 'en_attente') {
                html += `<button class="btn btn-sm btn-primary action-btn" data-action="confirmer" data-commande-id="${commandeId}"><i class="fas fa-check"></i> Confirmer</button>`;
                html += `<button class="btn btn-sm btn-info action-btn" data-action="en-preparation" data-commande-id="${commandeId}"><i class="fas fa-utensils"></i> En préparation</button>`;
                html += `<button class="btn btn-sm btn-danger action-btn" data-action="annuler" data-commande-id="${commandeId}"><i class="fas fa-times"></i> Annuler</button>`;
            } else if (data.statut === 'confirmee') {
                html += `<button class="btn btn-sm btn-info action-btn" data-action="en-preparation" data-commande-id="${commandeId}"><i class="fas fa-utensils"></i> En préparation</button>`;
                html += `<button class="btn btn-sm btn-success action-btn" data-action="prete" data-commande-id="${commandeId}"><i class="fas fa-check-double"></i> Prête</button>`;
                html += `<button class="btn btn-sm btn-success action-btn" data-action="livrer" data-commande-id="${commandeId}"><i class="fas fa-truck"></i> Livrer</button>`;
                html += `<button class="btn btn-sm btn-danger action-btn" data-action="annuler" data-commande-id="${commandeId}"><i class="fas fa-times"></i> Annuler</button>`;
            } else if (data.statut === 'en_preparation') {
                html += `<button class="btn btn-sm btn-success action-btn" data-action="prete" data-commande-id="${commandeId}"><i class="fas fa-check-double"></i> Prête</button>`;
                html += `<button class="btn btn-sm btn-success action-btn" data-action="livrer" data-commande-id="${commandeId}"><i class="fas fa-truck"></i> Livrer</button>`;
                html += `<button class="btn btn-sm btn-danger action-btn" data-action="annuler" data-commande-id="${commandeId}"><i class="fas fa-times"></i> Annuler</button>`;
            } else if (data.statut === 'prete') {
                html += `<button class="btn btn-sm btn-success action-btn" data-action="livrer" data-commande-id="${commandeId}"><i class="fas fa-truck"></i> Livrer</button>`;
            } else if (data.statut === 'livree') {
                html += `<button class="btn btn-sm btn-warning action-btn" data-action="retourner" data-commande-id="${commandeId}"><i class="fas fa-undo"></i> Retourner</button>`;
            } else if (data.statut === 'annulee' || data.statut === 'retournee') {
                // Plus d'action possible : on masque les boutons
                html += '';
            }
            actionsCell.innerHTML = html;
            // Réattacher les listeners sur les nouveaux boutons
            actionsCell.querySelectorAll('.action-btn').forEach(btn => {
                btn.addEventListener('click', function(event) {
                    event.preventDefault();
                    const action = this.dataset.action;
                    const commandeId = this.dataset.commandeId;
                    console.log('Click bouton action', action, commandeId);
                    executeAction(action, commandeId);
                });
            });
        }
    }

    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alertHtml = `<div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>`;
        
        const alertContainer = document.querySelector('.dashboard-header');
        alertContainer.insertAdjacentHTML('afterend', alertHtml);
        
        // Auto-dismiss après 5 secondes
        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.remove();
            }
        }, 5000);
    }
</script>

</body>
</html>
