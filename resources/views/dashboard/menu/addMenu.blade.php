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
            <h1 class="dashboard-title">Ajouter un menu</h1>
            <div class="dashboard-actions">
                <div class="dashboard-actions">
                    <a href="/menus" class="btn-orange">
                        Retour
                    </a>

                </div>

            </div>
        </div>

        <form action="{{ route('menu.store') }}" method="POST" class="form-style" enctype="multipart/form-data">
            @csrf
            @include('partials.form-error')

            <div class="form-group">
                <label for="title">Nom du menu</label>
                <input type="text" id="title" name="title" class="input" placeholder="affecter un nom au Menu"  required>
            </div>

            <div class="form-group">
                <label>Plats disponibles :</label>
                <ul style="list-style: none; padding-left: 0;">
                    @foreach($menuItems as $item)
                        <li>
                            <label>
                                <input type="checkbox" name="items[]" value="{{ $item->id }}"
                                    {{ (is_array(old('items')) && in_array($item->id, old('items'))) ? 'checked' : '' }}>
                                <i class="fas fa-leaf"></i> {{ $item->name }}
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="form-group">
                <button type="submit" class="btn-orange">
                    <i class="fas fa-plus"></i> Ajouter le menu
                </button>
            </div>
        </form>




    </main>
</div>



</body>
</html>
