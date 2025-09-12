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
            <h1 class="dashboard-title">Modifier les informations d'un plat</h1>
            <div class="dashboard-actions">
                <a href="{{route('menuItems')}}" class="btn-orange"> Retour</a>
            </div>
        </div>
        <section class="add-client-form-section">
            <form action="{{ route('editMenuItem.update',$menuItem->id) }}" method="POST" class="form-style" enctype="multipart/form-data">
                @csrf
                <x-form-error/>
                @method('put')
                <div class="form-group">
                    <label for="name">Nom du plat</label>
                    <input type="text" id="name" name="name" value="{{$menuItem->name}}" placeholder="Saisir le nom du plat" class="input" required>
                </div>

                <div class="form-group">
                    <label for="price">Prix du plat</label>
                    <input type="number" id="price" name="price" value="{{$menuItem->price}}" placeholder="Saisir le prix de plat" class="input" required>
                </div>
                <div class="form-group">
                    <label>Ingrédients</label>
                    <div class="checkbox-group">
                        @foreach($ingredients as $ingredient)
                            <div class="checkbox-item">
                                <label>
                                    <input type="checkbox" name="ingredients[]" value="{{ $ingredient->id }}"
                                        {{ in_array($ingredient->id, $menuItem->ingredients->pluck('id')->toArray()) ? 'checked' : '' }}>
                                    {{ $ingredient->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group">
                    <label for="category">Catégorie</label>
                    <select id="category" name="category_id" class="input" required>
                        <option value="">Sélectionnez une catégorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $menuItem->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Image actuelle</label>
                    <div class="current-image-container">
                        @if($menuItem->image)
                            <img src="{{ asset('storage/' . $menuItem->image) }}" alt="{{ $menuItem->name }}" class="current-image">
                        @else
                            <div class="no-image">
                                <i class="fas fa-camera"></i> Aucune image
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="image">Changer l'image</label>
                    <input type="file" id="image" name="image" class="input">
                    <small class="form-text">Laissez vide pour conserver l'image actuelle</small>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-orange"><i class="fas fa-check"></i> Modifier</button>
                </div>
            </form>
        </section>
    </main>
</div>
</body>
</html>
