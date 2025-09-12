@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold mb-6">Mes Commandes</h2>
                
                @if($commandes->count() > 0)
                    <div class="commandes-list">
                        @foreach($commandes as $commande)
                            <div class="commande-card">
                                <div class="commande-info">
                                    <div>
                                        <span class="commande-montant">{{ number_format($commande->total, 2) }} DH</span>
                                        <span class="badge-status badge-{{ $commande->statut }}">
                                            @switch($commande->statut)
                                                @case('en_attente') En attente @break
                                                @case('confirmee') Confirmée @break
                                                @case('en_preparation') En préparation @break
                                                @case('prete') Prête @break
                                                @case('livree') Livrée @break
                                                @case('annulee') Annulée @break
                                                @case('retournee') Retournée @break
                                                @default {{ $commande->statut }}
                                            @endswitch
                                        </span>
                                    </div>
                                    <div class="commande-date">
                                        {{ $commande->created_at->format('d/m/Y H:i') }}
                                    </div>
                                    <div class="commande-items">
                                        @foreach($commande->menuItems as $item)
                                            <div class="commande-item">
                                                {{ $item->pivot->quantity }}x {{ $item->name }} <span style="color:#aaa;">({{ number_format($item->pivot->price, 2) }} DH)</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="commande-actions">
                                    @if($commande->canBeCancelled())
                                        <button class="btn btn-outline btn-sm cancel-order" data-commande-id="{{ $commande->id }}">
                                            <i class="fas fa-times"></i> Annuler
                                        </button>
                                    @endif

                                    @if($commande->statut === 'retournee')
                                        <span class="badge badge-success">Retourné</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $commandes->links() }}
                    </div>
                @else
                    <div class="text-center text-gray-500 py-8">
                        <p>Vous n'avez pas encore passé de commande.</p>
                        <a href="{{ route('client.menus.index') }}" class="text-indigo-600 hover:text-indigo-900 mt-2 inline-block">
                            Parcourir le menu
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div id="default-toast" class="toast-bottom-left" style="display: flex;">
    <span>Bienvenue sur votre espace commandes !</span>
    <button class="toast-close" onclick="document.getElementById('default-toast').style.display='none'">&times;</button>
</div>

<style>
/* ... (garde le style popup existant) ... */
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
</style>

<script>
    setTimeout(() => {
        const toast = document.getElementById('default-toast');
        if (toast) toast.style.display = 'none';
    }, 6000);
</script>
@endsection
