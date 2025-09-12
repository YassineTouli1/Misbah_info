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
<x-nav-manager></x-nav-manager>

<!-- Dashboard Container -->
<div class="dashboard-container">
    <!-- Sidebar -->
    <x-sideNav></x-sideNav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Ajouter un plat</h1>
            <div class="dashboard-actions">
                <div class="dashboard-actions">
                    <a href="/menuItems" class="btn-orange">
                        Retour
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div style="background:#e6ffed;color:#046c4e;border:1px solid #a7f3d0;padding:10px 12px;border-radius:8px;margin-bottom:16px;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background:#ffe6e6;color:#991b1b;border:1px solid #fecaca;padding:10px 12px;border-radius:8px;margin-bottom:16px;">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="background:#fff7ed;color:#9a3412;border:1px solid #fed7aa;padding:10px 12px;border-radius:8px;margin-bottom:16px;">
                <ul style="margin:0; padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('menuItem.store') }}" method="POST" class="form-style" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Nom du plat</label>
                <input type="text" id="name" name="name" class="input" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="price">Prix</label>
                <input type="number" id="price" name="price" class="input" step="0.01" value="{{ old('price') }}" required>
            </div>

            <!-- Nouveau champ Catégorie -->
            <div class="form-group">
                <label for="category">Catégorie</label>
                <select id="category" name="category_id" class="input" required>
                    <option value="">Sélectionnez une catégorie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Ingrédients disponibles :</label>
                <ul style="list-style: none; padding-left: 0;">
                    @foreach($ingredients as $ingredient)
                        <li>
                            <label style="display: flex; align-items: center; gap: 10px;">
                                <input
                                    type="checkbox"
                                    name="ingredients[{{ $ingredient->id }}][id]"
                                    value="{{ $ingredient->id }}"
                                    class="ingredient-checkbox"
                                    onchange="toggleQuantityInput(this)"
                                    {{ old('ingredients.'.$ingredient->id.'.id') ? 'checked' : '' }}
                                >
                                <span style="flex-grow: 1;">{{ $ingredient->name }}</span>

                                <input
                                    type="number"
                                    name="ingredients[{{ $ingredient->id }}][quantite]"
                                    step="0.01"
                                    min="0.01"
                                    placeholder="Qte utilisée"
                                    class="quantity-input"
                                    style="width: 80px;"
                                    value="{{ old('ingredients.'.$ingredient->id.'.quantite') }}"
                                    {{ old('ingredients.'.$ingredient->id.'.id') ? '' : 'disabled' }}
                                    {{ old('ingredients.'.$ingredient->id.'.id') ? 'required' : '' }}
                                >

                                <span class="stock-badge">
                                 Stock: {{ $ingredient->quantite }} {{ $ingredient->unite ?? 'unités' }}
        </span>
                            </label>
                        </li>
                    @endforeach

                    <script>
                        function toggleQuantityInput(checkbox) {
                            const quantityInput = checkbox.closest('label').querySelector('.quantity-input');
                            const isChecked = checkbox.checked;
                            quantityInput.disabled = !isChecked;
                            quantityInput.required = isChecked; // require quantity if selected
                            if (!isChecked) {
                                quantityInput.value = '';
                            } else {
                                quantityInput.focus();
                            }
                        }

                        // If page reloads with validation errors, re-enable required for any checked items
                        window.addEventListener('DOMContentLoaded', function() {
                            document.querySelectorAll('.ingredient-checkbox').forEach(function(cb) {
                                if (cb.checked) {
                                    toggleQuantityInput(cb);
                                }
                            });
                        });
                    </script>
                </ul>
            </div>

            <div class="form-group">
                <label for="image">Image du plat</label>
                <input type="file" id="image" name="image" class="input" accept="image/*" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn-orange">
                    <i class="fas fa-plus"></i> Ajouter le plat
                </button>
            </div>
        </form>
    </main>
</div>
</body>
</html>
