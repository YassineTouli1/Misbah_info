<!DOCTYPE html>
<html lang="fr">
@include('partials.head-dashboard')
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
@include('partials.nav-manager')
<div class="dashboard-container" style="margin-top:70px;">
    @include('partials.sideNav')
    <main class="main-content">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Tableau de Bord</h1>
            
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-card-header">
                    <h3 class="stat-card-title">Commandes Aujourd'hui</h3>
                    <div class="stat-card-icon" style="background-color: var(--primary);">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
                <p class="stat-card-value">42</p>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <h3 class="stat-card-title">Revenus Aujourd'hui</h3>
                    <div class="stat-card-icon" style="background-color: #4CAF50;">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                </div>
                <p class="stat-card-value">2,450 Dhs</p>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <h3 class="stat-card-title">le Nombre total des Clients</h3>
                    <div class="stat-card-icon" style="background-color: #2196F3;">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                @if(isset($nbrClient))
                <p class="stat-card-value">{{$nbrClient}}</p>
                @endif
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <h3 class="stat-card-title">le Nombre total des plats proposés</h3>
                    <div class="stat-card-icon" style="background-color: #9C27B0;">
                        <i class="fas fa-utensils"></i>
                    </div>
                </div>
                @if(isset($nbrPlat))
                <p class="stat-card-value">{{$nbrPlat}}</p>
                @endif
            </div>
        </div>


    </main>
</div>

<script>
    // Animation pour les cartes stats
    document.addEventListener('DOMContentLoaded', function() {
        const statCards = document.querySelectorAll('.stat-card');

        statCards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>
</body>
</html>
