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
            <h1 class="dashboard-title">Ajouter ingredient</h1>
            <div class="dashboard-actions">
                <a href="{{route('stock.index')}}" class="btn-orange"> Retour</a>
            </div>
        </div>
        <section class="add-client-form-section">
            <form action="{{ route('stock.store') }}" method="POST" class="form-style" enctype="multipart/form-data">
                @csrf
                @include('partials.form-error')

                <div class="form-group">
                    <label for="name">Nom d'ingredient</label>
                    <input type="text" id="name" name="name" placeholder="Saisir ingredient" class="input" required>
                </div>

                <div class="form-group">
                    <label for="email">Quantite</label>
                    <input type="text" id="quantite" name="quantite" placeholder="Saisir quantite" class="input" required>
                </div>

                <div class="form-group">
                    <label for="phone_number">Price</label>
                    <input type="text" id="price" name="price" class="input" placeholder="Saisir price" required>
                </div>

                <div class="form-group">
                    <label for="fournisseur">Fournisseur</label>
                    <input type="text" id="fournisseur" name="fournisseur" placeholder="Saisir le nom de frourisseur" class="input" required>
                </div>

                <div class="form-group">
                    <label for="image">image</label>
                    <input type="file" id="image" name="image" placeholder="image" class="input" required>
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
