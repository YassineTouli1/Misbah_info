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
            <h1 class="dashboard-title">Les plats</h1>
            <div class="dashboard-actions">
                <a href="/addMenuItem" class="btn-orange">
                    <i class="fas fa-hamburger"></i> Créer un Plat
                </a>

                <a href="/menus" class="btn-orange">
                    Retour
                </a>
            </div>
        </div>

        <section class="menu-items-section">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($menuItems->count() > 0)
                <table class="table">
                    <thead>
                    <tr>
                        <th>Nom du plat</th>
                        <th>Prix</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($menuItems as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td class="item-price">{{ number_format($item->price, 2, ',', ' ') }} MAD</td>
                            <td>
                                <div class="item-image-container">
                                    @if($item->image)
                                        <img src="{{ Storage::url($item->image) }}"
                                             alt="{{ $item->name }}"
                                             class="item-image">
                                    @else
                                        <div class="no-image">
                                            <i class="fas fa-camera"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="/editMenuItem/{{$item->id}}">
                                    <button class="btn-edit">

                                        <i class="fas fa-edit"></i> Modifier

                                    </button>
                                    </a>
                                        <button class="delete-btn"
                                                data-resource-type="destroyMenuItem"
                                                data-resource-id="{{ $item->id }}"
                                                data-resource-name="{{ $item->name }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="fas fa-utensils"></i>
                    <p>Aucun plat disponible pour le moment</p>

                </div>
            @endif
        </section>
    </main>

</div>

@include('partials.deleteModal')

<script src="{{asset('js/deleteModal.js')}}"></script>
</body>
</html>
