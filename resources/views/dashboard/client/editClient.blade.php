<!DOCTYPE html>
<html lang="fr">
<x-head-dashboard/>

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
@include('partials.nav-manager')

<!-- Dashboard Container -->
<div class="dashboard-container">
    <!-- Sidebar -->
    @include('partials.sideNav')

    <!-- Main Content -->
    <main class="main-content">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Ajouter un Client</h1>
            <div class="dashboard-actions">
                <a href="{{route('clients')}}" class="btn-orange"> Retour</a>
            </div>
        </div>
        <section class="add-client-form-section">
            <form action="{{route('register')}}" method="POST" class="form-style">
                @csrf
                <input type="hidden" name="added_by_admin" value="1">
                <div class="form-group">
                    <label for="name">Nom Complet</label>
                    <input type="text" id="name" name="name" placeholder="Saisir le nom complet" class="input" required>
                </div>

                <div class="form-group">
                    <label for="email">Adresse Email</label>
                    <input type="email" id="email" name="email" placeholder="Saisir l'email" class="input" required>
                </div>

                <div class="form-group">
                    <label for="phone_number">Numéro de Téléphone</label>
                    <input type="tel" id="phone_number" name="phone_number" class="input" placeholder="Saisir le numéro de téléphone" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de Passe</label>
                    <input type="password" id="password" name="password" class="input" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmer le Mot de Passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirmer le password" class="input" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-orange"><i class="fas fa-check"></i> Ajouter</button>
                </div>
            </form>
        </section>


    </main>
</div>



</body>
</html>
