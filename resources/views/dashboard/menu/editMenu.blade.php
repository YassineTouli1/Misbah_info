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
            <h1 class="dashboard-title">Modifier les informations d'un meu</h1>
            <div class="dashboard-actions">
                <a href="{{route('menus')}}" class="btn-orange"> Retour</a>
            </div>
        </div>
        <section class="add-client-form-section">
            <form action="{{route('editMenu.update',$menu->id)}}" method="POST" class="form-style">
                @csrf
                @include('partials.form-error')
                @method('put')
                <div class="form-group">
                    <label for="title">Title de menu</label>
                    <input type="text" id="title" name="title" value="{{$menu->title}}" class="input" required>
                </div>
                <div class="form-group">
                    <label>Plats</label>
                    <div class="checkbox-group">
                        @foreach($menuItems as $item)
                            <div class="checkbox-item">
                                <label>
                                    <input type="checkbox" name="items[]" value="{{ $item->id }}"
                                        {{ in_array($item->id, $menu->menuItems->pluck('id')->toArray()) ? 'checked' : '' }}>
                                    {{ $item->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="available">
                        <input type="checkbox" id="available" name="available" value="1"
                            {{ $menu->available ? 'checked' : '' }}>
                        Disponible
                    </label>
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
