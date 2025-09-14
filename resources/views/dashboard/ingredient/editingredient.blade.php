<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Manager - Snack El Madina</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
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
@include('partials.nav-manager')

<!-- Dashboard Container -->
<div class="dashboard-container">
    <!-- Sidebar -->
    @include('partials.sideNav')

    <!-- Main Content -->
    <main class="main-content">
        <div class="dashboard-header">
            <h1 class="dashboard-title">edit ingredient</h1>
            <div class="dashboard-actions">
                <a href="{{route('stock.index')}}" class="btn-orange"> Retour</a>
            </div>
        </div>
        <section class="add-client-form-section">
            <form action="{{ route('ingredient.update',$ingredient->id) }}" method="POST" class="form-style" enctype="multipart/form-data">
                @csrf
                @method('put')
                @include('partials.form-error')

                <div class="form-group">
                    <label for="name">Nom d'ingredient</label>
                    <input type="text" id="name" name="name" placeholder="Saisir ingredient" class="input" value="{{ $ingredient->name }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Quantite</label>
                    <input type="text" id="quantite" name="quantite" placeholder="Saisir quantite" class="input" value="{{ $ingredient->quantite }}" required>
                </div>

                <div class="form-group">
                    <label for="phone_number">Price</label>
                    <input type="text" id="price" name="price" class="input" placeholder="Saisir price" value="{{ $ingredient->price }}" required>
                </div>

                <div class="form-group">
                    <label for="fournisseur">Fournisseur</label>
                    <input type="text" id="fournisseur" name="fournisseur" class="input" value="{{ $ingredient->fournisseur }}" required>
                </div>

                <div class="form-group">
                    <label for="image">Image actuelle :</label><br>
                    @if($ingredient->image)
                        <img src="{{ asset('storage/' . $ingredient->image) }}" alt="Image actuelle" style="width: 100px; height: auto; margin-bottom: 10px; border-radius: 5px;">
                    @endif

                    <label for="image">Changer l’image :</label>
                    <input type="file" id="image" name="image" class="input">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-orange"><i class="fas fa-check"></i> update </button>
                </div>
            </form>
        </section>


    </main>
</div>



</body>
</html>
