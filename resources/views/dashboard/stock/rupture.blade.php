<!DOCTYPE html>
<html lang="fr">
<link rel="stylesheet" href="{{asset('css/rupture.css')}}">

<x-head-dashboard/>

<body>
@include('partials.nav-manager')
<div class="dashboard-container" style="margin-top:70px;">
    @include('partials.sideNav')
    <main class="main-content">
        <div class="dashboard-header">
            <h1 class="dashboard-title">🛑 Ingrédients en Rupture de Stock</h1>
        </div>

        <div class="ingredient-cards-container">
            @forelse($ingredients as $ingred)
                <div class="ingredient-card">
                    <div class="icon-wrapper">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="ingredient-details">
                        <h2>{{ $ingred->name }}</h2>
                        <p>Quantité : <strong>{{ $ingred->quantite }}</strong></p>
                        <p class="alert-text">⚠️ Rupture de stock</p>
                    </div>
                </div>
            @empty
                <p class="no-rupture">✅ Tous les ingrédients sont disponibles.</p>
            @endforelse
        </div>

    </main>
</div>

</body>
</html>

