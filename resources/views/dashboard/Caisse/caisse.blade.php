<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caisse - Snack El Madina</title>

    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/caisse.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
.dashboard-container {
    display: flex;
    margin-top: 70px;
}
.main-container {
    flex: 1;
    min-width: 0;
}
.caisse-container {
    width: 100%;
    max-width: none;
}
</style>
</head>
<body>
    @include('partials.nav-manager')
    <div class="dashboard-container">
        @include('partials.sideNav')
        <div class="main-container">
            <div class="caisse-container">
                <div class="caisse-header">
                    <h1 class="caisse-title">
                        <i class="fas fa-cash-register"></i> Caisse
                    </h1>

                    <div class="ajout-vider-caisse">
                        <!-- Ajouter montant -->
                        <button type="button" class="ajouter" data-bs-toggle="modal" data-bs-target="#ajouterMontantModal">
                            <i class="fas fa-plus-circle"></i> ajouter montant
                        </button>

                        <!-- Tirer montant -->
                        <button type="button" class="vider" data-bs-toggle="modal" data-bs-target="#tirerMontantModal">
                            <i class="fas fa-minus-circle"></i> tirer montant
                        </button>
                    </div>

                    <div class="caisse-total">
                        <i class="fas fa-coins"></i>
                        <span>
                            @if($caisse)
                                {{ number_format($caisse->montant, 2) }} DH
                            @else
                                0.00 DH
                            @endif
                        </span>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="caisse-content">
                    <!-- Filtres et recherche -->
                    <div class="filters-section mb-4">
                        <form method="GET" action="{{ route('manager.caisse') }}" class="row g-3">
                            <div class="col-md-2">
                                <select name="type" class="form-select">
                                    <option value="">Tous les types</option>
                                    <option value="ajout" {{ $type == 'ajout' ? 'selected' : '' }}>Ajouts</option>
                                    <option value="retour" {{ $type == 'retour' ? 'selected' : '' }}>Retours</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="date_debut" class="form-control" value="{{ $dateDebut }}" placeholder="Date début">
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="date_fin" class="form-control" value="{{ $dateFin }}" placeholder="Date fin">
                            </div>

                        </form>
                    </div>

                    <!-- Transactions -->
                    <div class="transactions">
                        <div class="transactions-header d-flex justify-content-between align-items-center">
                            <h3>Historique des Transactions</h3>
                            <span class="badge bg-primary">{{ $transactions->total() }} transactions</span>
                        </div>

                        @if($transactions->count() > 0)
                            <div class="transaction-list">
                                @foreach($transactions as $transaction)
                                    <div class="transaction-item">
                                        <div class="transaction-info">
                                            <div class="transaction-header">
                                                <strong>{{ $transaction->reference }}</strong>
                                                <span class="badge bg-{{ $transaction->type == 'ajout' ? 'success' : 'danger' }}">
                                                    {{ $transaction->type_label }}
                                                </span>
                                            </div>
                                            <div class="transaction-details">
                                                <small>{{ $transaction->date_formatted }}</small>
                                                <br>
                                                <small class="text-muted">{{ $transaction->description }}</small>
                                                @if($transaction->commande)
                                                    <br>
                                                    <small class="text-info">
                                                        <i class="fas fa-shopping-cart"></i>
                                                        Commande #{{ $transaction->commande->id }}
                                                    </small>
                                                @endif
                                            </div>
                                            <div class="transaction-user">
                                                <small class="text-muted">
                                                    <i class="fas fa-user"></i> {{ $transaction->user->name }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="transaction-amount">
                                            <div class="amount {{ in_array($transaction->type, ['retour', 'tirage']) ? 'text-danger' : 'text-success' }}">
                                                {{ in_array($transaction->type, ['retour', 'tirage']) ? '-' : '+' }}{{ $transaction->montant_formatted }}
                                            </div>
                                            <div class="balance-info">
                                                <small class="text-muted">
                                                    Solde: {{ $transaction->solde_apres_formatted }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Pagination -->
                            <div class="pagination-wrapper mt-4">
                                {{ $transactions->appends(request()->query())->links() }}
                            </div>
                        @else
                            <div class="no-transactions">
                                <div class="text-center py-5">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <h5>Aucune transaction trouvée</h5>
                                    <p class="text-muted">Aucune transaction ne correspond à vos critères de recherche.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div> <!-- /.main-container -->
    </div> <!-- /.dashboard-container -->

    <!-- Modal Ajouter -->
    <div class="modal fade" id="ajouterMontantModal" tabindex="-1" aria-labelledby="ajouterMontantLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                @include('dashboard.Caisse.ajouter_pop_up')
            </div>
        </div>
    </div>

    <!-- Modal Tirer -->
    <div class="modal fade" id="tirerMontantModal" tabindex="-1" aria-labelledby="tirerMontantLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                @include('dashboard.Caisse.tirer_caisse_pop_up')
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
