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
            <h1 class="dashboard-title">Stock</h1>
            <div class="dashboard-actions">
                <a href="/addingredient" class="btn-orange"><i class="fas fa-plus"></i> Nouveau ingredient</a>
            </div>
        </div>

        <section class="ingredients-grid">
            @foreach($Stocks as $Stock)
                <div class="ingredient-card">
                    <div class="ingredient-image">
                        @if($Stock->ingredient->image)
                            <img src="{{ route('image.serve', ['folder' => 'ingredients', 'filename' => basename($Stock->ingredient->image)]) }}" alt="{{ $Stock->ingredient->name }}">
                        @else
                            <div class="no-image">No Image</div>
                        @endif
                    </div>
                    <div class="ingredient-details">
                        <h3>{{ $Stock->ingredient->name }}</h3>
                        <div class="ingredient-info">
                            <span class="info-label">Quantity:</span>
                            <span class="info-value">{{ $Stock->ingredient->quantite }} Unités</span>
                        </div>
                        <div class="ingredient-info">
                            <span class="info-label">Price:</span>
                            <span class="info-value">{{ $Stock->ingredient->price }} DH</span>
                        </div>
                        <div class="ingredient-info">
                            <span class="info-label">Supplier:</span>
                            <span class="info-value">{{ $Stock->ingredient->fournisseur }}</span>
                        </div>
                    </div>
                    <div class="ingredient-actions">
                        <button type="button" class="delete-btn"
                                data-resource-type="ingredients"
                                data-resource-id="{{ $Stock->ingredient->id }}"
                                data-resource-name="{{ $Stock->ingredient->name }}">
                            <i class="fas fa-trash"></i> supprimer
                        </button>
                        <form action="{{ route('ingredient.edit', $Stock->ingredient->id) }}" method="GET" style="display: inline;">
                            @csrf
                            <button type="submit" class="edit-btn">
                                <i class="fas fa-edit"></i> Modifier
                            </button>
                        </form>

                    </div>
                </div>
            @endforeach
        </section>
    </main>
</div>

<!-- Modal de confirmation de suppression -->
@include('partials.deleteModal')

<script src="{{ asset('js/deleteModal.js') }}"></script>
</body>
</html>
