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
            <h1 class="dashboard-title">Les Menus</h1>
            <div class="dashboard-actions">
                <a href="/menuItems" class="btn-orange">
                    <i class="fas fa-box"></i> Voir la liste des plats
                </a>
                <a href="/addMenu" class="btn-orange">
                    <i class="fas fa-utensils"></i> Créer un Menu
                </a>
            </div>
        </div>

        <div class="menus-grid">
            @foreach ($menus as $menu)
                <div class="menu-card">
                    <div class="menu-header">
                        <h2 class="menu-title">{{ $menu->title }}</h2>
                        <span class="menu-availability {{ $menu->available ? 'menu-available' : 'menu-unavailable' }}">
                            {{ $menu->available ? 'Disponible' : 'Indisponible' }}
                        </span>
                    </div>

                    <div class="menu-items-container">
                        <h3 class="menu-items-title">Plats dans ce menu :</h3>

                        @if($menu->menuItems->count())
                            <ul class="menu-items-list">
                                @foreach ($menu->menuItems as $item)
                                    <li class="menu-item">
                                        <img src="{{ asset('storage/'.$item->image) }}"
                                             alt="{{ $item->name }}"
                                             class="menu-item-image"
                                             onerror="this.onerror=null;this.src='{{ asset('images/placeholder.png') }}';">
                                        <div class="menu-item-details">
                                            <div class="menu-item-name">{{ $item->name }}</div>
                                            <div class="menu-item-price">{{ $item->price }} MAD</div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="empty-menu">Aucun plat dans ce menu.</div>
                        @endif
                    </div>

                    <div class="menu-footer">
                        <div class="menu-total-items">
                            {{ $menu->menuItems->count() }} plats
                        </div>
                        <div class="menu-actions">
                            <a href="/editMenu/{{$menu->id}}" class="btn btn-sm btn-edit-menu">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <button class="delete-btn"
                                    data-resource-type="deleteMenu"
                                    data-resource-id="{{ $menu->id }}"
                                    data-resource-name="{{ $menu->title }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
</div>
<x-deleteModal/>
<script src="{{asset('js/deleteModal.js')}}"></script>
</body>
</html>
