<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte - Snack El Madina</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{asset('css/profile.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
    /* Pop-up overlay */
    .popup-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.4);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .popup-box {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.18);
        padding: 32px 40px;
        min-width: 320px;
        max-width: 90vw;
        text-align: center;
        position: relative;
        animation: popup-in 0.2s;
    }
    .popup-box.success { border-left: 6px solid #28a745; }
    .popup-box.error { border-left: 6px solid #dc3545; }
    .popup-close {
        position: absolute;
        top: 12px;
        right: 16px;
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #888;
        cursor: pointer;
    }
    @keyframes popup-in {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    /* Commandes cards */
    .commandes-list {
        display: flex;
        flex-direction: column;
        gap: 24px;
        margin-top: 24px;
    }
    .commande-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        padding: 24px 32px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }
    .commande-info {
        flex: 2;
        min-width: 220px;
    }
    .commande-actions {
        flex: 1;
        min-width: 180px;
        display: flex;
        gap: 8px;
        align-items: center;
        justify-content: flex-end;
    }
    .badge-status {
        padding: 4px 12px;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 600;
        display: inline-block;
    }
    .badge-en_attente { background: #fff3cd; color: #856404; }
    .badge-confirmee { background: #d1e7dd; color: #0f5132; }
    .badge-en_preparation { background: #cff4fc; color: #055160; }
    .badge-prete { background: #e2e3e5; color: #41464b; }
    .badge-livree { background: #cfe2ff; color: #084298; }
    .badge-annulee { background: #f8d7da; color: #842029; }
    .badge-retournee { background: #f8d7da; color: #842029; }
    .badge-livree, .badge-prete { border: 1px solid #b6d4fe; }
    .commande-montant { font-size: 1.3rem; font-weight: bold; color: #ff6600; }
    .commande-date { color: #888; font-size: 0.95rem; }
    .commande-items { margin: 8px 0 0 0; }
    .commande-item { font-size: 0.98rem; }
    .btn { border-radius: 6px; padding: 6px 14px; font-size: 0.98rem; }
    .btn-outline { border: 1px solid #ff6600; color: #ff6600; background: #fff; }
    .btn-outline:hover { background: #ff6600; color: #fff; }
    .toast-bottom-left {
        position: fixed;
        left: 24px;
        bottom: 24px;
        z-index: 9999;
        min-width: 260px;
        background: #222;
        color: #fff;
        border-radius: 10px;
        padding: 18px 28px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.18);
        font-size: 1.08rem;
        display: flex;
        align-items: center;
        gap: 12px;
        animation: toast-in 0.4s;
    }
    @keyframes toast-in {
        from { opacity: 0; transform: translateY(30px);}
        to { opacity: 1; transform: translateY(0);}
    }
    .toast-bottom-left .toast-close {
        background: none;
        border: none;
        color: #fff;
        font-size: 1.3rem;
        margin-left: auto;
        cursor: pointer;
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
    .badge-status, .badge {
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
    .btn {
        border-radius: 8px;
        padding: 7px 18px;
        font-size: 1rem;
        margin-bottom: 4px;
        transition: background 0.2s, color 0.2s;
    }
    .btn-outline {
        border: 1.5px solid #ff6600;
        color: #ff6600;
        background: #fff;
    }
    .btn-outline:hover {
        background: #ff6600;
        color: #fff;
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

     .btn-orange {
         background-color: #ff9800; /* orange vif */
         color: white;
         font-weight: bold;
         padding: 12px 20px;
         border: none;
         border-radius: 12px;
         font-size: 16px;
         cursor: pointer;
         display: inline-flex;
         align-items: center;
         gap: 8px;
         text-decoration: none;
         box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
         transition: background-color 0.3s ease;
     }

    .btn-orange:hover {
        background-color: #fb8c00; /* un peu plus foncé au hover */
    }
    </style>

    </style>
</head>
<body>

<style>
    .btn-orange {
        background-color: #ff9800; /* orange vif */
        color: white;
        font-weight: bold;
        padding: 12px 20px;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease;
    }

    .btn-orange:hover {
        background-color: #fb8c00; /* un peu plus foncé au hover */
    }
</style>

<!-- Navbar -->
<x-nav-profile/>

<!-- Main Content -->
<div class="client-container">
    <!-- Welcome Section -->
    <section class="welcome-section">
        <div class="welcome-content">
            <h1 class="welcome-title">Bienvenue, {{Auth::User()->name}} !</h1>
            <p class="welcome-text">Découvrez nos délicieux plats préparés avec des ingrédients frais et une touche d'amour. Commandez en ligne et profitez d'une expérience culinaire exceptionnelle.</p>
            <a href="{{route('client.menus')}}" class="btn-orange">
                <i class="fas fa-utensils"></i> Voir le Menu
            </a>
        </div>
    </section>

    <!-- Messages de session -->
    @if(session('success'))
        <div class="alert alert-success" style="margin: 20px; padding: 15px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 8px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" style="margin: 20px; padding: 15px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 8px;">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger" style="margin: 20px; padding: 15px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 8px;">
            <i class="fas fa-exclamation-circle"></i>
            <ul style="margin: 5px 0 0 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <!-- Orders Section -->
    <section class="orders-section">
        <h2 class="section-title">Mes Dernières Commandes</h2>
        @if($commandes->count() > 0)
            <div class="table-responsive">
                <table class="orders-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Plats</th>
                        <th>Total</th>
                        <th>Statut</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($commandes as $commande)
                        <tr>
                            <td>#{{ $commande->id }}</td>
                            <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($commande->menuItems->count() > 0)
                                    <ul class="list-unstyled" style="margin:0;padding:0;">
                                        @foreach($commande->menuItems as $item)
                                            <li>
                                                {{ $item->pivot->quantity }}x {{ $item->name ?? $item->nom }}
                                                <small style="color:#888;">({{ number_format($item->pivot->price, 2) }} DH)</small>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted">Aucun article</span>
                                @endif
                            </td>
                            <td><strong>{{ number_format($commande->total, 2) }} DH</strong></td>
                            <td>
                                <span class="status-badge status-{{ $commande->statut }}">
                                    @if($commande->statut === 'livree' && $commande->validee_par_client)
                                        <span class="badge badge-success" style="background:#28a745; color:#fff;">Validée</span>
                                    @else
                                        @switch($commande->statut)
                                            @case('en_attente') En attente @break
                                            @case('confirmee') Confirmée @break
                                            @case('en_preparation') En préparation @break
                                            @case('prete') Prête @break
                                            @case('livree') <span class="badge" style="background:#cfe2ff; color:#084298;">Livrée</span> @break
                                            @case('annulee') <span class="badge badge-danger" style="background:#f8d7da; color:#842029;">Annulée</span> @break
                                            @case('retournee') <span class="badge badge-danger" style="background:#f8d7da; color:#842029;">Retournée</span> @break
                                            @default {{ $commande->statut }}
                                        @endswitch
                                    @endif
                                </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-shopping-cart"></i>
                <p>Vous n'avez pas encore passé de commande</p>
                <a href="{{ route('client.menus') }}" class="btn-orange">
                    <i class="fas fa-utensils"></i> Commander maintenant
                </a>
            </div>
        @endif
    </section>
</div>

<div id="default-toast" class="toast-bottom-left" style="display: flex;">
    <span>Bienvenue sur votre espace commandes !</span>
    <button class="toast-close" onclick="document.getElementById('default-toast').style.display='none'">&times;</button>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion de l'annulation des commandes
    document.querySelectorAll('.cancel-order').forEach(btn => {
        btn.addEventListener('click', function() {
            const commandeId = this.dataset.commandeId;

            if (confirm('Êtes-vous sûr de vouloir annuler cette commande ?')) {
                // Envoyer la requête d'annulation
                fetch(`/client/commandes/${commandeId}/annuler`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Afficher un message de succès
                        showAlert('success', data.message);

                        // Recharger la page pour mettre à jour les statuts
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        showAlert('error', data.message);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    showAlert('error', 'Une erreur est survenue');
                });
            }
        });
    });





    function showAlert(type, message) {
        // Supprimer les anciens popups
        document.querySelectorAll('.popup-overlay').forEach(e => e.remove());
        const alertClass = type === 'success' ? 'success' : 'error';
        const popupHtml = `
            <div class="popup-overlay">
                <div class="popup-box ${alertClass}">
                    <button class="popup-close" onclick="this.closest('.popup-overlay').remove()">&times;</button>
                    <div style="font-size:2.2rem;margin-bottom:10px;">
                        ${type === 'success' ? '✅' : '❌'}
                    </div>
                    <div style="font-size:1.2rem;">${message}</div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', popupHtml);
        // Auto-dismiss après 4 secondes
        setTimeout(() => {
            const popup = document.querySelector('.popup-overlay');
            if (popup) popup.remove();
        }, 4000);
    }
});

setTimeout(() => {
    const toast = document.getElementById('default-toast');
    if (toast) toast.style.display = 'none';
}, 6000);
</script>

</body>
</html>
